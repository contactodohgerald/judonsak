<?php

namespace App\Http\Controllers;


use App\Jobs\SendTaskEmail;
use App\Models\{Client, Department, Instruction, Note, Person, Status, Task};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function submitTask(Request $request)
    {
        $request->validate([
            'client' => 'required|integer',
            'contract' => 'required|integer',
            'service' => 'required|integer',
            'instruction' => 'required|integer',
            'task' => 'required|min:5|max:255',
            'description' => 'required|min:5|max:255',
            'executor' => 'required',
            'supervisor' => 'required',
            'dead_line' => 'nullable|date'
        ]);

        $task = new Task;
        $task->name = $request->task;
        $task->instruction_id = $request->instruction;
        $task->description = $request->description;
        $task->deadline = $request->dead_line;
        $task->executor_id = $request->executor;
        $task->line_manager_id = $request->supervisor;

        $task->save();
        $task->people()->attach($request->people);

        $executor = Person::where('id', $request->executor)->first();

        $this->sendNewTaskMail($executor->user, $task);

        return redirect()->route('task.index');
    }

    private function sendNewTaskMail($user, $task)
    {
        return SendTaskEmail::dispatch($task, $user)
            ->delay(now()->addMinutes(5));

        // return Notification::send($user, new NewTaskNotification($task));
    }

    public function index(Instruction $instruction)
    {
        $status = Status::all();
        $instruction->with('tasks')->get();
        return view(
            'client.contract.instruction.task.index',
            compact('instruction', 'status')
        );
    }

    public function create(Instruction $instruction)
    {
        $people = Person::where('level_id', '<', '5')->get();
        $instruction->load('person');
        $task = null;
        $status = Status::all();
        return view(
            'client.contract.instruction.task.create',
            compact('task', 'instruction', 'people', 'status')
        );
    }

    public function store(Request $request, Instruction $instruction)
    {
        $request->validate([
            'task' => 'required|min:2|max:255',
            'description' => 'required|min:5|max:255',
            'people' => 'required|array',
            'deadline' => 'nullable|date'
        ]);

        $task = new Task;
        $task->name = $request->task;
        $task->description = $request->description;
        $task->deadline = $request->deadline;

        $instruction->tasks()->save($task);
        $task->people()->attach($request->people);

        $people = Person::whereIn('id', $request->people)->get();

        foreach ($people as $person) {
            logPersonAction(
                1,
                Auth::id(),
                '<a href="' . route('profile.show', ['profile.show' => currentUser()->person->slug]) . '"> ' . currentUser()->name . '</a> Assigned a <a href ="' . route(
                    'instruction.task.show',
                    [
                        'instruction' => $task->instruction->slug,
                        'task' => $task->slug
                    ]
                ) .
                    '"> Task </a> to 
                    <a href="' . route('profile.show', ['profile.show' => $person->slug]) . '"> '
                    . $person->first_name . ' ' . $person->last_name . '</a>',
                $task
            );

            $this->sendNewTaskMail($person->user, $task);
        }

        return redirect()
            ->route(
                'instruction.task.index',
                ['instruction' => $instruction->slug]
            );
    }

    public function show(Instruction $instruction, Task $task)
    {
        // $task->load('instruction.contract', 'people', 'notes');
        $task->load('instruction.contract', 'executor', 'notes');

        foreach ($task->executor->user->unreadNotifications as $notification) {
            if ($notification->data['task_name'] === $task->name) {
                $notification->markAsRead();
            }
        }

        return view(
            'client.contract.instruction.task.show',
            compact('task')
        );
    }

    public function serviceShow(Task $task)
    {
        return redirect()
            ->route(
                'instruction.task.show',
                [
                    'instruction' => $task->instruction->slug,
                    'task' => $task->slug
                ]
            );
    }

    public function edit(Instruction $instruction, Task $task)
    {
        $people = Person::where('level_id', '<', '5')->get();
        $status = Status::all();
        $instruction->load('person');
        return view(
            'client.contract.instruction.task.create',
            compact('task', 'instruction', 'people', 'status')
        );
    }

    public function update(Request $request, Instruction $instruction, Task $task)
    {
        $request->validate([
            'task' => 'required|min:2|max:255',
            'description' => 'required|min:3|max:255',
            'people' => 'required|array',
            'deadline' => 'nullable|date'
        ]);

        $task->name = $request->task;
        $task->description = $request->description;
        $task->status_id = $request->status;
        $task->deadline = $request->deadline;
        $task->save();

        $task->people()->sync($request->people);

        $people = Person::whereIn('id', $request->people)->get();
        foreach ($people as $person) {
            logPersonAction(
                2,
                Auth::id(),
                '<a href="' . route('profile.show', ['profile.show' => currentUser()->person->slug]) . '"> ' . currentUser()->name . '</a> Updated a<a href ="' . route(
                    'instruction.task.show',
                    [
                        'instruction' => $task->instruction->slug,
                        'task' => $task->slug
                    ]
                ) .
                    '"> Task </a>',
                $task
            );
        }

        return redirect()->route(
            'instruction.task.index',
            ['instruction' => $instruction->slug]
        )->with(
            'status',
            toastReturnUpdate()
        );
    }

    public function destroy(Instruction $instruction, Task $task)
    {
        $department = Department::where('id', '=', 3)->first();
        if (Auth::user()->person->level_id >= 5 || Auth::user()->person->id == $department->person_id) {
            logPersonAction(
                4,
                Auth::id(),
                currentUser()->name . ' Deleted a Task ',
                $task
            );
            // todo, check why soft delete is not working
            $task->forceDelete();

            $message = 'Task Deleted Successfully';
            $type = 'info';
            $titl = 'Success';
        } else {
            $message = 'Only Partners and Departmental Heads Can Delete Tasks';
            $type = 'warning';
            $titl = 'Error';

            logPersonAction(
                3,
                Auth::id(),
                '<a href="' . route('profile.show', ['profile.show' => currentUser()->person->slug]) . '"> ' . currentUser()->name . '</a> Tried to Delete a <a href ="' . route(
                    'instruction.task.show',
                    [
                        'instruction' => $task->instruction->slug,
                        'task' => $task->slug
                    ]
                ) .
                    '"> Task </a>',
                $task
            );
        }
        return redirect()
            ->route('instruction.task.index', ['instruction' => $instruction->slug])
            ->with('status', toastReturnUpdate(
                $message,
                $type,
                $titl
            ));
    }

    public function directIndex()
    {
        $status = Status::all();
        $tasks = Task::orderBy('tasks.id', 'desc')->get();
        // $tasks = Task::all();

        $tasks->load('instruction.contract.client', 'status', 'executor');
        // $tasks->load('instruction.contract.client', 'status', 'people');

        // dd($tasks);

        // foreach ($tasks as $task) {
        //     dd($task->executor->slug);
        // }

        return view('task.index', compact('tasks', 'status'));
    }

    public function directQuery($query)
    {
        switch ($query) {
            case 'pending':
                $status = 4;
                $tasks = Task::where('status_id', $status)
                    ->orderBy('created_at', 'desc')
                    ->with("executor")
                    ->get();
                return view('task.pending', ['tasks' => $tasks]);
                break;
            case 'ongoing':
                $status = 5;
                $tasks = Task::where('status_id', $status)
                    ->orderBy('created_at', 'desc')
                    ->with("executor")
                    ->get();
                return view('task.ongoing', ['tasks' => $tasks]);
                break;
            case 'overdue':
                $status = 6;
                $tasks = Task::where('status_id', $status)
                    ->orderBy('created_at', 'desc')
                    ->with("executor")
                    ->get();
                return view('task.overdue', ['tasks' => $tasks]);
                break;
            case 'completed':
                $status = 7;
                $tasks = Task::where('status_id', $status)
                    ->orderBy('created_at', 'desc')
                    ->with("executor")
                    ->get();

                return view('task.completed', ['tasks' => $tasks]);
                break;

            case 'awaiting-review':
                $status = 22;
                // $tasks = Task::where('status_id', $status)
                //     ->orderBy('created_at', 'desc')
                //     ->with("executor")
                //     ->get();
                // return view('task.awaiting-review', ['tasks' => $tasks]);
                break;

            case 'task-manager':
                $status = [4, 5, 6, 7, 21, 22];
                $tasks = Task::whereIn('status_id', $status)
                    ->orderBy('created_at', 'desc')
                    ->get();
                if ($tasks) {
                    $tasks->load('instruction.contract.client', 'status', 'people');
                }
                return view('task.manager', ['tasks' => $tasks]);
                break;

            default:
                abort(404);
                break;
        }

        if ($status == 22) {
            $tasks = Task::where('status_id', '=', $status)
                ->orderBy('tasks.id', 'desc')
                ->with('executor')
                ->get();

            if ($tasks) {
                $tasks->load('instruction.contract.client', 'status', 'people');
            }
            return view('task.awaiting-review', ['tasks' => $tasks]);
        }
        if (Auth::user()->person->level_id > 5) {
            $tasks = Task::where([
                ['status_id', '=', $status]
            ])
                ->orderBy('tasks.id', 'desc')
                ->get();
        } else {
            $tasks = Task::whereHas('people', function ($q) {
                $q->where('person_id', '=', Auth::user()->person->id);
            })->where([
                ['status_id', '=', $status]
            ])
                ->orderBy('tasks.id', 'desc')
                ->get();
        }
        $tasks->load('instruction.contract.client', 'status', 'people');

        return view('task.index', ['tasks' => $tasks, 'status' => $status]);
    }

    // public function directStore(Request $request)
    // {

    //     $request->validate([
    //         'client'   => 'required|integer',
    //         'contract' => 'required|integer',
    //         'service'  => 'required|integer',
    //         'instruction' => 'required|integer',
    //         'task'        => 'required|min:5|max:255',
    //         'description' => 'required|min:5|max:255',
    //         'executor'      => 'required',
    //         'supervisor'      => 'required',
    //         'dead_line'   => 'nullable|date'
    //     ]);

    //     $task = new Task;
    //     $task->name = $request->task;
    //     $task->instruction_id = $request->instruction;
    //     $task->description = $request->description;
    //     $task->deadline = $request->dead_line;
    //     $task->executor_id = $request->executor;
    //     $task->line_manager_id = $request->supervisor;

    //     $task->save();
    //     $task->people()->attach($request->people);

    //     // $person = Person::where('id', $request->people)->get();

    //     // logPersonAction(
    //     //     1,
    //     //     Auth::id(),
    //     //     '<a href="' . route('profile.show', ['profile.show' => currentUser()->person->slug]) . '"> ' . currentUser()->name . '</a> Assigned a <a href ="' . route(
    //     //         'instruction.task.show',
    //     //         [
    //     //             'instruction' => $task->instruction->slug,
    //     //             'task' => $task->slug
    //     //         ]
    //     //     ) .
    //     //         '"> Task </a> to 
    //     //             <a href="' . route('profile.show', ['profile.show' => $person->slug]) . '"> '
    //     //         . $person->first_name . ' ' . $person->last_name . '</a>',
    //     //     $task
    //     // );

    //     // $this->sendNewTaskMail($person->user, $task);

    //     // $person->id;

    //     // $task->save();

    //     return redirect()
    //         ->route('task.index');
    // }

    public function directCreate()
    {
        $people = Person::all();
        $clients = Client::all();
        $contract = null;
        $instruction = null;
        return view(
            'task.create',
            compact('clients', 'contract', 'instruction', 'people')
        );
    }

    public function storeModal(Request $request)
    {
        $request->validate([
            'instruction' => 'required|integer',
            'task' => 'required|min:2|max:255',
            'people' => 'required|array',
            'description' => 'required|min:3|max:255',
            'deadline' => 'nullable|date'
        ]);

        $task = new Task;
        $task->name = $request->task;
        $task->instruction_id = $request->instruction;
        $task->description = $request->description;
        $task->deadline = $request->deadline;

        $task->save();

        $task->people()->attach($request->people);

        $people = Person::whereIn('id', $request->people)->get();

        foreach ($people as $person) {
            logPersonAction(
                1,
                Auth::id(),
                '<a href="' . route('profile.show', ['profile.show' => currentUser()->person->slug]) . '"> ' . currentUser()->name . '</a> Assigned a <a href ="' . route(
                    'instruction.task.show',
                    [
                        'instruction' => $task->instruction->slug,
                        'task' => $task->slug
                    ]
                ) .
                    '"> Task </a> to 
                    <a href="' . route('profile.show', ['profile.show' => $person->slug]) . '"> '
                    . $person->first_name . ' ' . $person->last_name . '</a>',
                $task
            );

            $this->sendNewTaskMail($person->user, $task);
        }

        return redirect()
            ->back()
            ->with('status', toastReturnUpdate(
                'Task Created Successfully',
                'success',
                'Success'
            ));
    }

    public function createNote(Request $request)
    {
        $request->validate([
            'task' => 'required|min:2|max:250',
            'body' => 'required|min:2|max:250'
        ]);
        $task = Task::where('slug', '=', $request->task)->first();
        $note = new Note;
        $note->body = $request->body;
        $note->task_id = $task->id;
        $note->person_id = Auth::user()->person->id;
        $note->save();

        logPersonAction(
            1,
            Auth::id(),
            '<a href="' . route('profile.show', ['profile.show' => currentUser()->person->slug]) . '"> ' . currentUser()->name . '</a> Created a <a href ="' . route(
                'instruction.task.show',
                [
                    'instruction' => $task->instruction->slug,
                    'task' => $task->slug
                ]
            ) .
                '"> Note </a>',
            $note
        );

        return redirect()
            ->back()
            ->with('status', toastReturnUpdate(
                'Note Created Successfully',
                'success',
                'Success'
            ));
    }

    /* Task Notifications */

    public function updateStatus(Request $request)
    {
        $request->validate([
            'task' => 'required|min:5|max:255',
            'status' => 'required|integer',
        ]);

        $task = Task::where('slug', '=', $request->task)->first();
        $task->status_id = $request->status;
        $task->save();

        logPersonAction(
            2,
            Auth::id(),
            '<a href="' . route('profile.show', ['profile.show' => currentUser()->person->slug]) . '"> ' . currentUser()->name . '</a> Updated a <a href ="' . route(
                'instruction.task.show',
                [
                    'instruction' => $task->instruction->slug,
                    'task' => $task->slug
                ]
            ) .
                '"> Task </a> status to ' . $task->status->name,
            $task
        );

        return redirect()
            ->back()
            ->with('status', toastReturnUpdate(
                'Update Successfull',
                'success',
                'Success'
            ));
    }


    /* Task under supervision */

    public function supervisorTask($query)
    {
        switch ($query) {
            case 'pending':
                $status = 4;
                $tasks = Task::where('line_manager_id', Auth::user()->id)
                    ->where('status_id', $status)
                    ->orderBy('created_at', 'desc')
                    ->with('executor')
                    ->get();

                return view('task.pending', ['tasks' => $tasks]);
                break;
            case 'ongoing':
                $status = 5;
                $tasks = Task::where('line_manager_id', Auth::user()->id)
                    ->where('status_id', $status)
                    ->orderBy('created_at', 'desc')
                    ->with('executor')
                    ->get();

                return view('task.ongoing', ['tasks' => $tasks]);
                break;

            case 'overdue':
                $status = 6;
                $tasks = Task::where('line_manager_id', Auth::user()->id)
                    ->where('status_id', $status)
                    ->orderBy('created_at', 'desc')
                    ->with('executor')
                    ->get();

                return view('task.overdue', ['tasks' => $tasks]);
                break;
            case 'completed':
                $status = 7;
                $tasks = Task::where('line_manager_id', Auth::user()->id)
                    ->where('status_id', $status)
                    ->orderBy('created_at', 'desc')
                    ->with('executor')
                    ->get();

                return view('task.completed', ['tasks' => $tasks]);
                break;

            case 'awaiting-review':
                $status = 22;
                $tasks = Task::where('line_manager_id', Auth::user()->id)
                    ->where('status_id', $status)
                    ->orderBy('created_at', 'desc')
                    ->with('executor')
                    ->get();

                return view('task.awaiting-review', ['tasks' => $tasks]);
                break;
            default:
                abort(404);
                break;
        }

        return redirect()->back()->with('status', toastReturnUpdate(
            'Line Manager Point Awarded.',
            'success',
            'Success'
        ));
    }

    public function bestEmployee()
    {
        $people = Person::select(
            'people.id',
            'first_name',
            'last_name',
            DB::raw('(IFNULL(SUM(hr_point),0) + IFNULL(SUM(line_manager_point),0) + IFNULL(SUM(partners_point),0))as totalPoints')
        )
            ->leftJoin('task_points', 'people.id', '=', 'task_points.person_id')
            ->leftJoin('general_points', 'people.id', '=', 'general_points.person_id')
            ->groupBy('people.id', 'first_name', 'last_name')
            ->orderBy('totalPoints', 'desc')
            ->get();
        $empOfMonth = $people[0];


        return view('profile.best_employee', compact('people', 'empOfMonth'));
    }
}
