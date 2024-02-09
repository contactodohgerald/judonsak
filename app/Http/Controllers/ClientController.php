<?php

namespace App\Http\Controllers;

use App\Models\{
    Client,
    State,
    Service,
    Person,
    Contract,
    Task,
    Instruction,
    Cashbook
};
use App\User;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('snrassociates', ['only' => [
            'create',
            'edit',
            'store',
            'update',
        ]]);

        // $this->middleware('businessdev')
        //     ->only(
        //         [
        //             'create',
        //             'edit',
        //             'store',
        //             'update',
        //             'destroy'
        //         ]
        //     );
    }

    public function index()
    {
        $clients = Client::orderBy('created_at', 'desc')->get();
        return view('client.index', compact(('clients')));
    }

    public function manager()
    {
        $clients = Client::whereHas('instructions', function ($query) {
            $query->whereIn('instructions.status_id', [1, 4, 5, 6, 22]);
        })
            ->orderBy('created_at', 'desc')
            ->get();
        $insCount = 0;
        return view('client.manager', compact('clients', 'insCount'));
    }

    public function create()
    {
        $states = State::all();
        $client = null;
        return view('client.create', compact('states', 'client'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name'     => 'required|min:2|max:255',
                'email'    => 'nullable|max:255',
                'phone'    => 'nullable|min:2|max:20',
                'address'  => 'nullable|min:2|max:255',
                'state'    => 'required|integer',
                'tin'      => 'nullable|max:255',
                'rcn'      => 'nullable|max:255',
                'nob'      => 'nullable|min:2|max:255',
                'industry' => 'nullable|min:2|max:255',
            ]
        );

        if (isset($request->contact_name)) {
            $request->validate(
                [
                    'contact_name' => 'required|array',
                    'contact_designation'  => 'required|array'
                ]
            );
        }

        $client                     = new Client;
        $client->name               = $request->name;
        $client->email              = $request->email;
        $client->phone_num          = $request->phone;
        $client->address            = $request->address;
        $client->state_id           = $request->state;
        $client->tin                = $request->tin;
        $client->rcn                = $request->rcn;
        $client->nature_of_business = $request->nob;
        $client->industry           = $request->industry;

        $client->save();

        logPersonAction(
            1,
            Auth::id(),
            '<a href="' . route('profile.show', ['profile.show' => currentUser()->person->slug]) . '"> ' . currentUser()->name . '</a> Created a 
            <a href ="' . route(
                'client.show',
                ['client' => $client->slug]
            ) . '"> Client </a>',
            $client
        );

        // create contacts
        if (isset($request->contact_name)) {

            $body = [];
            $count = count($request->contact_name);
            for ($i = 0; $i < $count; $i++) {
                $body[] = [
                    'name' => $request->contact_name[$i],
                    'designation' => $request->contact_designation[$i],
                    'phone_num'   => $request->contact_phone[$i],
                    'email'       => $request->contact_email[$i],
                    'birthday'    => date(
                        'Y-m-d',
                        strtotime(
                            $request->contact_birthday[$i]
                        )
                    ),
                    'anniversary' => date(
                        'Y-m-d',
                        strtotime(
                            $request->contact_annivasary[$i]
                        )
                    )
                ];
            }

            $client->contacts()->createMany($body);
        }

        return redirect('/client')->with('status', toastReturnSuccess());
    }

    public function show(Client $client)
    {
        $client->load(
            'descContracts.payments',
            'descContracts.status',
            'descContracts.currency'
        )->orderBy('id', 'desc');
        $corporateNGN = Cashbook::where(
            [
                ['client_id', '=', $client->id],
                ['category_id', '=', 1],
                ['currency_id', '=', 1],
                ['group_id', '=', 1]
            ]
        )->sum('amount') - Cashbook::where(
            [
                ['category_id', '=', 1],
                ['currency_id', '=', 1],
                ['group_id', '=', 2]
            ]
        )->sum('amount');
        $corporateUSD = Cashbook::where(
            [
                ['client_id', '=', $client->id],
                ['category_id', '=', 1],
                ['currency_id', '=', 2],
                ['group_id', '=', 1]
            ]
        )->sum('amount') - Cashbook::where(
            [
                ['category_id', '=', 1],
                ['currency_id', '=', 2],
                ['group_id', '=', 2]
            ]
        )->sum('amount');

        $clientNGN = Cashbook::where(
            [
                ['client_id', '=', $client->id],
                ['category_id', '=', 2],
                ['currency_id', '=', 1],
                ['group_id', '=', 1]
            ]
        )->sum('amount') - Cashbook::where(
            [
                ['category_id', '=', 2],
                ['currency_id', '=', 1],
                ['group_id', '=', 2]
            ]
        )->sum('amount');
        $clientUSD = Cashbook::where(
            [
                ['client_id', '=', $client->id],
                ['category_id', '=', 2],
                ['currency_id', '=', 2],
                ['group_id', '=', 1]
            ]
        )->sum('amount') - Cashbook::where(
            [
                ['category_id', '=', 2],
                ['currency_id', '=', 2],
                ['group_id', '=', 2]
            ]
        )->sum('amount');
        return view(
            'client.show',
            compact(
                'client',
                'corporateNGN',
                'corporateUSD',
                'clientUSD',
                'clientNGN'
            )
        );
    }

    public function edit(Client $client)
    {
        $states = State::all();
        return view('client.create', compact('states', 'client'));
    }

    public function update(Request $request, Client $client)
    {
        // validate request email is equal to client email....todo.
        $request->validate(
            [
                'name'     => 'required|min:2|max:255',
                'email'    => "nullable",
                'phone'    => 'nullable|min:5|max:20',
                'address'  => 'min:5|max:255',
                'state'    => 'required|integer',
                'tin'      => 'nullable|max:255',
                'rcn'      => 'nullable|max:255',
                'nob'      => 'nullable|min:2|max:255',
                'industry' => 'nullable|min:2|max:255',
            ]
        );

        if (isset($request->contact_name)) {
            $request->validate([
                'contact_name' => 'required|array',
                'contact_designation'  => 'required|array'
            ]);
        }

        $client->name               = $request->name;
        $client->email              = $request->email;
        $client->phone_num          = $request->phone;
        $client->address            = $request->address;
        $client->state_id           = $request->state;
        $client->tin                = $request->tin;
        $client->rcn                = $request->rcn;
        $client->nature_of_business = $request->nob;
        $client->industry           = $request->industry;

        $client->save();

        logPersonAction(
            2,
            Auth::id(),
            '<a href="' . route('profile.show', ['profile.show' => currentUser()->person->slug]) . '"> ' . currentUser()->name . '</a> Updated a 
            <a href ="' . route(
                'client.show',
                [
                    'client' => $client->slug
                ]
            ) . '"> Client </a>',
            $client
        );

        // create contacts
        if (isset($request->contact_name)) {
            $body = [];
            $count = count($request->contact_name);
            for ($i = 0; $i < $count; $i++) {
                $request->contact_email[$i];
                $body[] = [
                    'name' => $request->contact_name[$i],
                    'designation' => $request->contact_designation[$i] ?? null,
                    'phone_num'   => $request->contact_phone[$i] ?? null,
                    'email'       => $request->contact_email[$i] ?? null,
                    'birthday'    => $request->contact_birthday[$i] ? date(
                        'Y-m-d',
                        strtotime(
                            $request->contact_birthday[$i]
                        )
                    ) : null,
                    'anniversary' => $request->contact_annivasary[$i] ? date(
                        'Y-m-d',
                        strtotime(
                            $request->contact_annivasary[$i]
                        )
                    ) : null
                ];
            }
            // dd($body, $request);
            $client->contacts()->delete($body);

            $client->contacts()->createMany($body);
        }
        return redirect()
            ->route('client.edit', ['client' => $client->slug])
            ->with('status', toastReturnUpdate());
    }

    public function destroy(Client $client)
    {
        // dd('touch(filename)');
        $client->delete();

        logPersonAction(
            3,
            Auth::id(),
            currentUser()->name . ' Deleted a Client',
            $client
        );

        return redirect()
            ->route('client.index')
            ->with('status', toastReturnSuccess());
    }

    public function createImport()
    {
        return view('client.import');
    }
}
