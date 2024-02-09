<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\{
    Contract,
    Instruction,
    Client,
    Service,
    Status,
    Document,
    Currency
};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('snrassociates', ['only' => [
            'directCreate',
            'directIndex',
            'directStore',
            'destroy',
            'create',
            'store'
        ]]);

        // $this->middleware(['partners', 'snrassociates'])->only([
        //     'directCreate',
        //     'directIndex',
        //     'directStore',
        //     'create',
        //     'index',
        //     'destroy',
        // ]);
    }


    /* START: CLIENT CONTRACT CREATION */
    public function index()
    {
        $contracts = $this->getContracts();
        return view('contract.index', compact('contracts'));
    }

    public function create(Client $client)
    {
        $contract   = null;
        $clients    = null;
        $currencies = Currency::all();
        $statuses   = Status::all();
        $services   = Service::all();

        return view(
            'client.contract.create',
            compact(
                'client',
                'clients',
                'contract',
                'statuses',
                'services',
                'currencies'
            )
        );
    }

    public function store(Request $request, Client $client)
    {
        $request->validate(
            [
                'name'        => 'required|min:5|max:255',
                'service'     => 'nullable',
                'amount'      => 'nullable',
                'currency'    => 'nullable',
                'enddate'     => 'nullable|date',
                'rate'        => 'nullable',
                'paydate'     => 'nullable'
            ]
        );

        $contract               = new Contract;
        $contract->name         = $request->name;
        $contract->person_id    = $request->user()->id;
        $contract->amount       = $request->amount;
        $contract->currency_id  = $request->currency;
        $contract->start_date   = ($request->startdate) ? (date('Y-m-d', strtotime($request->startdate))) : null;
        $contract->end_date     = ($request->enddate) ? (date('Y-m-d', strtotime($request->enddate))) : null;

        // create contract
        $client->contracts()->save($contract);

        if ($request->file('sla')) {
            $name = $request->file('sla')->getClientOriginalName();
            $path = $request->file('sla')->store('contract');
            $document = new Document;
            $document->name = $name;
            $document->path = $path;
            $document->folder_id = 1;
            $document->client_id = $client->id;
            // $document->contract_id = $contract->id;
            $document->save();
        }

        logPersonAction(
            1,
            Auth::id(),
            '<a href="' . route('profile.show', ['profile.show' => currentUser()->person->slug]) . '"> ' . currentUser()->name . '</a> Created a <a href ="' . route(
                'client.contract.show',
                [
                    'client' => $contract->client->slug,
                    'contract' => $contract->slug
                ]
            ) . '"> Contract </a>',
            $contract
        );

        // create payments
        $body = [];
        $count = ($request->rate) ? count($request->rate) : 0;
        for ($i = 0; $i < $count; $i++) {
            $body[$i] = [
                'percent' => $request->rate[$i],
                'due_date' => date('Y-m-d', strtotime($request->paydate[$i]))
            ];
        }

        $contract->addPayments($body);

        // create services
        $contract->services()->attach($request->service);

        return redirect()
            ->route(
                'client.show',
                [
                    'client' => $client->slug
                ]
            )->with(
                'status',
                toastReturnUpdate(
                    'Action Successfull',
                    'success',
                    'Success'
                )
            );
    }


    /* CLIENT->INSTRUCTION->INDEX */
    public function show(Client $client, Contract $contract)
    {
        $contract->with(
            [
                'services.instructions' => function (
                    $query
                ) use ($contract) {
                    $query->where('instructions.contract_id', $contract->id);
                }
            ]
        )->get();

        $instructions = Instruction::orderBy('created_at', 'desc')->get();
        return view(
            'client.contract.instruction.index',
            compact('instructions', 'contract')
        );
    }


    /* CLIENT->CONTRACT->EDIT */
    public function edit(Client $client, Contract $contract)
    {
        $currencies = Currency::all();
        $clients    = Client::all();
        $statuses   = Status::all();
        $services   = Service::all();

        return view(
            'client.contract.create',
            compact(
                'client',
                'clients',
                'contract',
                'statuses',
                'services',
                'currencies'
            )
        );
    }

    /* CLIENT->CONTRACT->UPDATE */
    public function update(Request $request, Client $client, Contract $contract)
    {
        $request->validate(
            [
                'name'        => 'required|min:5|max:255',
                'client'      => 'required|max:255',
                'service'     => 'nullable',
                'amount'      => 'required',
                'currency'    => 'nullable',
                'enddate'     => 'nullable|date',
                'rate'        => 'nullable',
                'paydate'     => 'nullable'
            ]
        );

        $contract->name         = $request->name;
        $contract->client_id    = $request->client;
        $contract->person_id    = $request->user()->id;
        $contract->amount       = str_replace(',', '', $request->amount);
        $contract->currency_id  = $request->currency;
        $contract->start_date   = ($request->startdate) ? (date('Y-m-d', strtotime($request->startdate))) : null;
        $contract->end_date     = ($request->enddate) ? (date('Y-m-d', strtotime($request->enddate))) : null;

        $contract->save();

        if ($request->file('sla')) {
            /**
             * TODO
             * check if contract has existing SLA before you upload new 
             **/
            $name = $request->file('sla')->getClientOriginalName();
            $path = $request->file('sla')->store('contract');
            $document = new Document;
            $document->name = $name;
            $document->path = $path;
            $document->folder_id = 1;
            $document->contract_id = $contract->id;
            $document->client_id = $contract->client_id;
            $document->save();
        }

        logPersonAction(
            2,
            Auth::id(),
            '<a href="' . route('profile.show', ['profile.show' => currentUser()->person->slug]) . '"> ' . currentUser()->name . '</a> Updated a <a href ="' . route(
                'client.contract.show',
                [
                    'client' => $contract->client->slug,
                    'contract' => $contract->slug
                ]
            ) . '"> Contract </a>',
            $contract
        );

        // update payments
        $contract->payments()->forceDelete();

        $body = [];
        $count = ($request->rate) ? count($request->rate) : 0;
        for ($i = 0; $i < $count; $i++) {
            $body[$i] = [
                'percent' => $request->rate[$i],
                'due_date' => date('Y-m-d', strtotime($request->paydate[$i]))
            ];
        }

        $contract->addPayments($body);

        // update services
        $contract->services()->sync($request->service);

        return redirect()
            ->route('client.show', ['client' => $contract->client->slug])
            // ->back()
            ->with(
                'status',
                toastReturnUpdate(
                    'Update Successfull',
                    'success',
                    'Success'
                )
            );
    }

    /* CLIENT->CONTRACT->DESTROY */
    public function destroy(Client $client, Contract $contract)
    {
        $contract->delete();

        logPersonAction(
            3,
            Auth::id(),
            currentUser()->name . ' Deleted a Contract',
            $contract
        );

        return redirect()
            ->back()
            ->with(
                'status',
                toastReturnUpdate(
                    'Action Successfull',
                    'info',
                    'Success'
                )
            );
    }
    /* END OF CLIENT CONTRACT CREATION */


    private function getContracts()
    {
        return Contract::orderBy('name')->get();
    }


    /* START: DIRECT CONTRACT CREATION */
    public function directIndex()
    {
        $contracts = $this->getContracts();
        return view('contract.index', compact('contracts'));
    }


    public function directCreate()
    {
        $contract   = null;
        $clients    = Client::all();
        $currencies = Currency::all();
        $statuses   = Status::all();
        $services   = Service::all();
        return view(
            'contract.create',
            compact('clients', 'contract', 'statuses', 'services', 'currencies')
        );
    }


    public function directStore(Request $request)
    {
        // $request->validate([
        //     'name'        => 'required|min:5|max:255',
        //     'client'      => 'required',
        //     'service'     => 'nullable',
        //     'amount'      => 'nullable',
        //     'currency'    => 'nullable',
        //     'enddate'     => 'nullable|date',
        //     'rate'        => 'required_with:enddate|array',
        //     'paydate'     => 'required_with:enddate|array'
        // ]);

        $request->validate(
            [
                'name'  => 'required|min:5|max:255',
                'client' => 'required',
                'service' => 'nullable',
                'amount'  => 'nullable',
                'currency' => 'nullable',
                'startdate' => 'required|date',
                'enddate' => 'required|date',
                'rate' => 'nullable|array',
                'paydate' => 'nullable|array'
            ]
        );

        $contract               = new Contract;
        $contract->name         = $request->name;
        $contract->client_id    = $request->client;
        $contract->person_id    = $request->user()->id;
        $contract->amount       = str_replace(',', '', $request->amount);
        $contract->currency_id  = $request->currency;
        $contract->start_date   =  (date('Y-m-d', strtotime($request->startdate))) ?? null;
        $contract->end_date     =  (date('Y-m-d', strtotime($request->enddate))) ?? null;

        $contract->save();


        if ($request->file('sla')) {
            $name = $request->file('sla')->getClientOriginalName();
            $path = $request->file('sla')->store('contract');
            $document = new Document;
            $document->name = $name;
            $document->path = $path;
            $document->folder_id = 1;
            // $document->contract_id = $contract->id;
            $document->client_id = $contract->client_id;
            $document->save();
        }

        logPersonAction(
            1,
            Auth::id(),
            '<a href="' . route('profile.show', ['profile.show' => currentUser()->person->slug]) . '"> ' . currentUser()->name . '</a> Created a <a href ="' . route(
                'client.contract.show',
                [
                    'client' => $contract->client->slug,
                    'contract' => $contract->slug
                ]
            ) . '"> Contract </a>',
            $contract
        );

        // create payments
        $body = [];
        $count = ($request->rate) ? count($request->rate) : 0;
        for ($i = 0; $i < $count; $i++) {
            $body[$i] = [
                'percent' => $request->rate[$i],
                'due_date' => date('Y-m-d', strtotime($request->paydate[$i]))
            ];
        }

        $contract->addPayments($body);

        // create services
        $contract->services()->attach($request->service);

        return redirect()
            ->route('contract.index')
            ->with(
                'status',
                toastReturnUpdate(
                    'Action Successfull',
                    'success',
                    'Success'
                )
            );
    }
    /* END: CONTRACT DIRECT CREATION */
}
