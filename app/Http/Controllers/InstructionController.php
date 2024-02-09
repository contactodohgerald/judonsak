<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\{Instruction, Person, Client, Contract, Service, Department};
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;

class InstructionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('associate', ['only' => [
            'directStore',
            'directCreate',
            'destroy',
            'create',
            'update',
            'edit'
        ]]);

        // $this->middleware('businessdev')->only(
        //     ['destroy']
        // );
    }

    public function index(Contract $contract)
    {
        $contract->with(
            [
                'services.instructions' => function ($query) use ($contract) {
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

    public function create(Contract $contract)
    {
        $people   = Person::has('department')->get();
        $contract->load('services');
        $services = $contract->services;
        $instruction = null;
        return view(
            'client.contract.instruction.create',
            compact(
                'contract',
                'instruction',
                'services',
                'people'
            )
        );
    }

    public function store(Request $request, Contract $contract)
    {
        $request->validate(
            [
                'instruction' => 'required|min:3|max:255',
                'service'     => 'required',
                'contract'    => 'required',
                'people'      => 'required|array',
                'remark'      => 'required'
            ]
        );

        $instruction = new Instruction;
        $instruction->name = $request->instruction;
        $instruction->contract_id = $contract->id;
        $instruction->remark = $request->remark;
        $instruction->service_id = $request->service;

        $instruction->save();

        $instruction->people()->attach($request->people);

        logPersonAction(
            1,
            Auth::id(),
            '<a href="' . route('profile.show', ['profile.show' => currentUser()->person->slug]) . '"> ' . currentUser()->name . '</a> Created an <a href ="' . route(
                'instruction.task.index',
                [
                    'instruction' => $instruction->slug
                ]
            ) . '"> Instruction </a>',
            $instruction
        );

        return redirect()
            ->route(
                'contract.instruction.index',
                ['contract' => $contract->slug]
            )->with(
                'status',
                toastReturnUpdate(
                    'Action Successfull',
                    'success',
                    'Success'
                )
            );
    }

    public function show(Contract $contract, Instruction $instruction)
    {
        //
    }

    public function edit(Contract $contract, Instruction $instruction)
    {
        $people   = Person::all();
        $otherContracts = Client::where('id', '=', $contract->client_id)->first()->contracts;
        $contract->load('services');
        $services = $contract->services;
        return view(
            'client.contract.instruction.create',
            compact(
                'contract',
                'otherContracts',
                'services',
                'instruction',
                'people'
            )
        );
    }

    public function update(
        Request $request,
        Contract $contract,
        instruction $instruction
    ) {
        $request->validate(
            [
                'instruction' => 'required|min:5|max:255',
                'service'     => 'required',
                'contract'    => 'required',
                'people'      => 'required|array',
                'remark'      => 'required'
            ]
        );

        $instruction->name = $request->instruction;
        $instruction->remark = $request->remark;
        $instruction->service_id = $request->service;

        if ($request->selectcontract != $request->contract) {
            // contract has been changed
            $instruction->contract_id = $request->selectcontract;
            $newContract = Contract::where('id', '=', $request->selectcontract)->first();
            if (!$newContract->services->contains($request->service)) {
                $newContract->services()->attach($request->service);
            }
            $contract = $newContract;
        }
        $instruction->save();

        logPersonAction(
            2,
            Auth::id(),
            '<a href="' . route('profile.show', ['profile.show' => currentUser()->person->slug]) . '"> ' . currentUser()->name . '</a> Updated an 
            <a href ="' . route(
                'instruction.task.index',
                [
                    'instruction' => $instruction->slug
                ]
            ) . '"> Instruction </a>',
            $instruction
        );


        $instruction->people()->sync($request->people);

        return redirect()->route(
            (Auth::user()->person->department_id == 3) ?
                'instruction.index' : 'contract.instruction.index',
            ['contract' => $contract->slug]
        )->with('status', toastReturnUpdate());
    }

    public function destroy(Contract $contract, Instruction $instruction)
    {
        $department = Department::where('id', '=', 3)->first();
        if (Auth::user()->person->level_id >= 5 || Auth::user()->person->id == $department->person_id) {
            $instruction->delete();

            logPersonAction(
                3,
                Auth::id(),
                currentUser()->name . ' Deleted an Instruction',
                $instruction
            );

            $message = 'Instruction Deleted Successfully';
            $type = 'info';
            $titl = 'Success';
        } else {
            $message = 'Only Partners and Departmental Heads Can Delete Tasks';
            $type = 'info';
            $titl = 'Success';
        }

        return redirect()
            ->back()
            ->with(
                'status',
                toastReturnUpdate(
                    $message,
                    $type,
                    $titl
                )
            );
    }

    public function directCreate()
    {
        $people   = Person::has('department')->get();
        $clients = Client::all();
        $contract = null;
        $instruction = null;
        return view(
            'instruction.create',
            compact(
                'clients',
                'contract',
                'instruction',
                'people'
            )
        );
    }

    public function directStore(Request $request)
    {
        // if you are not HOD, Business Dev or Partner. (Changed)
        // Senior Associate and Associate shoudl be able to create instructions
        if (
            $request->user()->person->id != $request->user()->person->department->person_id &&
            $request->user()->person->department_id != 5 &&
            $request->user()->person->level_id < 2
        ) {
            abort(403);
        }
        $request->validate(
            [
                'instruction' => 'required|min:5|max:255',
                'service'     => 'required|integer',
                'contract'    => 'required|integer',
                'people'      => 'required|array',
                'remark'      => 'required'
            ]
        );

        $instruction = new Instruction;
        $instruction->name = $request->instruction;
        $instruction->contract_id = $request->contract;
        $instruction->service_id = $request->service;
        $instruction->remark = $request->remark;

        $instruction->save();

        logPersonAction(
            1,
            Auth::id(),
            '<a href="' . route('profile.show', ['profile.show' => currentUser()->person->slug]) . '"> ' . currentUser()->name . '</a> Created an 
            <a href ="' . route(
                'instruction.task.index',
                [
                    'instruction' => $instruction->slug
                ]
            ) . '"> Instruction </a>',
            $instruction
        );

        $instruction->people()->attach($request->people);
        $contract = Contract::find($request->contract);

        return redirect()
            ->route(
                'contract.instruction.index',
                [
                    'contract' => $contract->slug
                ]
            )->with('status', toastReturnUpdate(
                'Action Successfull',
                'success',
                'Success'
            ));;
    }

    // Olamide directIndex
    public function directIndex()
    {
        $instructions = Instruction::orderBy('created_at', 'desc')->get();
        $instructions->load('contract.client');
        $people = Person::where('department_id', '=', 3)->get();

        return view('instruction.index', compact('instructions', 'people'));
    }

    public function directQuery($query)
    {
        switch ($query) {
            case 'pending':
                $status = 4;
                $instructions = Instruction::where('status_id', $status)->orderBy('created_at', 'desc')->get();
                $people = Person::where('department_id', '=', 3)->get();
                return view('instruction.pending', compact('instructions', 'people'));
                break;
            case 'ongoing':
                $status = 5;
                $instructions = Instruction::where('status_id', $status)->orderBy('created_at', 'desc')->get();
                $people = Person::where('department_id', '=', 3)->get();
                return view('instruction.ongoing', compact('instructions', 'people'));
                break;

            case 'inactive':
                $status = 1;
                $instructions = Instruction::where('status_id', $status)->orderBy('created_at', 'desc')->get();
                $people = Person::where('department_id', '=', 3)->get();
                return view('instruction.inactive', compact('instructions', 'people'));
                break;

            case 'completed':
                $status = 7;
                $instructions = Instruction::where('status_id', $status)->orderBy('created_at', 'desc')->get();
                $people = Person::where('department_id', '=', 3)->get();
                return view('instruction.completed', compact('instructions', 'people'));
                break;

            case 'overdue':
                $status = 6;
                $instructions = Instruction::where('status_id', $status)->orderBy('created_at', 'desc')->get();
                $people = Person::where('department_id', '=', 3)->get();
                return view('instruction.overdue', compact('instructions', 'people'));
                break;

            case 'kiv':
                $status = 21;
                $instructions = Instruction::where('status_id', $status)->orderBy('created_at', 'desc')->get();
                $people = Person::where('department_id', '=', 3)->get();
                return view('instruction.kiv', compact('instructions', 'people'));
                break;

            case 'awaiting-review':
                $status = 22;
                break;

            case 'manager':
                $status = [1, 4, 5, 6, 7, 21, 22];
                $instructions = Instruction::with(
                    ['contract.client' => function ($query) {
                        $query->orderBy('name');
                    }]
                )->whereIn(
                    'status_id',
                    $status
                )->get();
                $people = Person::where('department_id', '=', 3)->get();
                return view('instruction.manager', compact('instructions', 'people'));
                break;

            default:
                abort(404);
                break;
        }

        if ($status == 22) {
            $instructions = Instruction::where(
                'status_id',
                '=',
                $status
            )->orderBy('created_at', 'desc')->get();
            $instructions->load('contract.client');
            $people = Person::where('department_id', '=', 3)->get();
            return view('instruction.index', compact('instructions', 'people'));
        }

        $person = Auth::user()->person;
        $instructions = Instruction::where('status_id', '=', $status)
            ->whereHas(
                'people',
                function ($query) use ($person) {
                    $query->where('people.id', '=', $person->id);
                }
            )
            ->orderBy('created_at', 'desc')
            ->get();
        $instructions->load('contract.client', 'tasks');
        $people = Person::where('department_id', '=', 3)->get();
        return view('instruction.index', compact('instructions', 'people'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'instruction' => 'required|min:3|max:255',
            'status' => 'required|integer',
        ]);

        $instruction = Instruction::where(
            'slug',
            '=',
            $request->instruction
        )->first();
        $instruction->status_id   = $request->status;
        $instruction->save();

        logPersonAction(
            2,
            Auth::id(),
            '<a href="' . route('profile.show', ['profile.show' => currentUser()->person->slug]) . '"> ' . currentUser()->name . '</a> Updated the status an 
            <a href ="' . route(
                'instruction.task.index',
                [
                    'instruction' => $instruction->slug
                ]
            ) . '"> Instruction </a>',
            $instruction
        );

        return redirect()
            ->back()
            ->with('status', toastReturnUpdate());
    }

    public function updateStatusAPI(Request $request)
    {
        $request->validate([
            'instruction' => 'required',
            'status' => 'required',
        ]);

        $instruction = Instruction::where(
            'slug',
            '=',
            $request->instruction
        )->first();
        $instruction->status_id   = $request->status;
        $instruction->save();

        logPersonAction(
            2,
            Auth::id(),
            '<a href="' . route('profile.show', ['profile.show' => currentUser()->person->slug]) . '"> ' . currentUser()->name . '</a> Updated the status an 
            <a href ="' . route(
                'instruction.task.index',
                [
                    'instruction' => $instruction->slug
                ]
            ) . '"> Instruction </a>',
            $instruction
        );

        return response()->json(
            ['status' => 'success', 'message' => $instruction->status->name, 'id' => $instruction->id]
        );
    }

    public function viewDeleted()
    {
        $instructions = Instruction::onlyTrashed()->orderBy(
            'deleted_at',
            'desc'
        )->get();
        $instructions->load('contract.client');
        $people = Person::where('department_id', '=', 3)->get();
        return view('instruction.restore', compact('instructions', 'people'));
    }

    public function restoreDeleted($instruction)
    {
        // restore deleted instruction
        $restore = Instruction::onlyTrashed()
            ->where('slug', $instruction)
            ->first()->restore();

        return back()
            ->with('status', toastReturnUpdate('Restored Successfully'));
    }

    //API for clients and contract 
    public function clientAPI($id)
    {
        $client = Client::find($id);
        return $client->contracts;
    }

    public function contractAPI($id)
    {
        $contract = Contract::find($id);
        return $contract->services;
    }

    public function serviceAPI($id)
    {
        $service = Service::find($id);
        return $service->instructions;
    }

    public function instructionAPI($id)
    {
        $instruction = Instruction::find($id);
        return $instruction->people;
    }

    public function getContractServicesAPI($contract, $service)
    {
        $instructions = Instruction::where(
            [
                ['contract_id', '=', $contract],
                ['service_id', '=', $service],
            ]
        )->get();

        return $instructions;
    }
}
