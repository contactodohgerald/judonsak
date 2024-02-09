<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{Task, Contract, Instruction, Person, Service, Client};
use App\User;

class ImportController extends Controller
{
    protected $import_client; 
    protected $import_contract; 
    protected $import_service; 
    protected $import_instruction; 
    protected $import_task; 
    protected $import_user; 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function createClientManager() 
    {        
        return view('client.import');
    }

    public function storeClientManager(Request $request)
    {
        // dd($request->file('import_file'));
        $collection = (new FastExcel)->import($request->file('import_file'));
        $total = $collection->count();
        for ($i=0; $i < $total; $i++) {
         // check if its a new client 
            if (empty($collection[$i]['Client'])) {

                if (empty($collection[$i]['Service'])) {

                    // save instructions
                    $this->import_instruction = new Instruction;
                    $this->import_instruction->name = $collection[$i]['Instructions'];
                    $this->import_instruction->service_id = $this->import_service->id;
                    $this->import_instruction->contract_id = $this->import_contract->id;
                    $this->import_instruction->status_id = 5;
                    $this->import_instruction->remark = $collection[$i]['Remarks'];
                    $this->import_instruction->save();

                    // Create Tax Professional
                    $this->import_user = User::where('email', '=', $collection[$i]['Email'])->first();
                    if (!$this->import_user) {
                        $this->import_user = new User;
                        $this->import_user->name = $collection[$i]['InCharge'];
                        $this->import_user->email = $collection[$i]['Email'];
                        $this->import_user->password = Hash::make('password');
                        $this->import_user->save();
                    }
                    if (!$this->import_user->person) {
                        // save the person
                        $person = new Person;
                        $collect_names = explode(' ', $collection[$i]['InCharge']);
                        $person->first_name = $collect_names[0];
                        $person->last_name = $collect_names[1] ?? '------';
                        $person->department_id = 3;
                        $person->level_id = 4;
                        $person->state_id = 25;
                        $person->phone_num = '08012345678';
                        $person->user_id = $this->import_user->id;
                        $person->save();    
                    }
                        // Save task
                    if (!empty($collection[$i]['ToDo'])) {
                        // save Instruction Manager
                        $todo_person = User::where('id', '=' , $this->import_user->id)->first(); 
                        $this->import_instruction->people()->attach($todo_person->person->id);

                        $todo = new Task;
                        $todo->name = $collection[$i]['ToDo'];
                        $todo->description = 'Managers can give hints on how the task should be carried out';
                        $todo->person_id = $todo_person->person->id;
                        $todo->instruction_id = $this->import_instruction->id;
                        $todo->deadline = date('Y-m-d', strtotime("+1 week"));
                        $todo->save();
                     } 
                } else {
                    // check if service exist in db and create if it doesnt
                    $this->import_service = Service::where('name', '=', $collection[$i]['Service'])->first();
                    if(!$this->import_service){
                        $this->import_service = new Service;
                        $this->import_service->name = $collection[$i]['Service'];
                        $this->import_service->save();
                    }
                    // create attach services to contract
                    $this->import_contract->services()->attach($this->import_service->id);

                    // save instructions
                    $this->import_instruction = new Instruction;
                    $this->import_instruction->name = $collection[$i]['Instructions'];
                    $this->import_instruction->service_id = $this->import_service->id;
                    $this->import_instruction->contract_id = $this->import_contract->id;
                    $this->import_instruction->status_id = 5;
                    $this->import_instruction->remark = $collection[$i]['Remarks'];
                    $this->import_instruction->save();

                    // Create Tax Professional
                    $this->import_user = User::where('email', '=', $collection[$i]['Email'])->first();
                    if (!$this->import_user) {
                        $this->import_user = new User;
                        $this->import_user->name = $collection[$i]['InCharge'];
                        $this->import_user->email = $collection[$i]['Email'];
                        $this->import_user->password = Hash::make('password');
                        $this->import_user->save();
                    }
                    if (!$this->import_user->person) {
                        // save the person
                        $person = new Person;
                        $collect_names = explode(' ', $collection[$i]['InCharge']);
                        $person->first_name = $collect_names[0];
                        $person->last_name = $collect_names[1] ?? '------';
                        $person->department_id = 3;
                        $person->level_id = 4;
                        $person->state_id = 25;
                        $person->phone_num = '08012345678';
                        $person->user_id = $this->import_user->id;
                        $person->save();
                    }

                    if (!empty($collection[$i]['ToDo'])) {
                        // Save todo 
                        $todo_person = User::where('id', '=' , $this->import_user->id)->first();
                        // save Instruction Manager
                        $this->import_instruction->people()->attach($todo_person->person->id);

                        $todo = new Task;
                        $todo->name = $collection[$i]['ToDo'];
                        $todo->description = 'Managers can give hints on how the task should be carried out';
                        $todo->person_id = $todo_person->person->id;
                        $todo->instruction_id = $this->import_instruction->id;
                        $todo->deadline = date('Y-m-d', strtotime("+1 week"));
                        $todo->save();
                    }
                }

            } else {
                $this->import_client = new Client;
                $this->import_client->name = $collection[$i]['Client'];
                $this->import_client->save();
                // if($i > 1)
                    // dd($this->import_client);

                // check if service exist in db and create if it doesnt
                $this->import_service = Service::where('name', '=', $collection[$i]['Service'])->first();
                if(!$this->import_service){
                    $this->import_service = new Service;
                    $this->import_service->name = $collection[$i]['Service'];
                    $this->import_service->save();
                }

                $this->import_contract = new Contract;
                $this->import_contract->name = date('Y').' Contract With '.$collection[$i]['Client'];
                $this->import_contract->client_id = $this->import_client->id;
                $this->import_contract->save();
        
                $this->import_contract->services()->attach($this->import_service->id);

                // save instructions
                $this->import_instruction = new Instruction;
                $this->import_instruction->name = $collection[$i]['Instructions'];
                $this->import_instruction->service_id = $this->import_service->id;
                $this->import_instruction->contract_id = $this->import_contract->id;
                $this->import_instruction->status_id = 5;
                $this->import_instruction->remark = $collection[$i]['Remarks'];
                $this->import_instruction->save();

                // Create Tax Professional
                $this->import_user = User::where('email', '=', $collection[$i]['Email'])->first();
                if (!$this->import_user) {
                    $this->import_user = new User;
                    $this->import_user->name = $collection[$i]['InCharge'];
                    $this->import_user->email = $collection[$i]['Email'];
                    $this->import_user->password = Hash::make('password');
                    $this->import_user->save();
                }
                if (!$this->import_user->person) {
                    // save the person
                    $person = new Person;
                    $collect_names = explode(' ', $collection[$i]['InCharge']);
                    $person->first_name = $collect_names[0];
                    $person->last_name = $collect_names[1] ?? '------';
                    $person->department_id = 3;
                    $person->level_id = 4;
                    $person->state_id = 25;
                    $person->phone_num = '08012345678';
                    $person->user_id = $this->import_user->id;
                    $person->save();
                }
                if (!empty($collection[$i]['ToDo'])) {
                    $todo_person = User::where('id', '=' , $this->import_user->id)->first();
                    // save Instruction Manager
                    $this->import_instruction->people()->attach($todo_person->person->id);
                    // Save todo                 
                    $todo = new Task;
                    $todo->name = $collection[$i]['ToDo'];
                    $todo->description = 'Managers can give hints on how the task should be carried out';
                    $todo->person_id = $todo_person->person->id;
                    $todo->instruction_id = $this->import_instruction->id;
                    $todo->deadline = date('Y-m-d', strtotime("+1 week"));
                    $todo->save();
                }
            }
        }

        $data = ['message' => 'Import Successfull', 'type'=> 'success', 'titl' => 'Success'];

        return redirect()->route('instruction.index')->with('status', $data);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
