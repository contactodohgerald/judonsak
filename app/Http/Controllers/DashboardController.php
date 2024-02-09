<?php

namespace App\Http\Controllers;

use App\Models\{Checklist, Client, Contract, Department, Instruction, Log, Person, Project, Service, Task, TaskPoint};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = Auth::user();

        $user->load('person.level', 'person.department');

        // dd($user->person);

        switch ($user->type_id) {
            case 1: //user is a client
                break;

            case 2: //user is a corperate use
                if ($user->person->level_id > 4) {
                    $department = Department::where('id', '=', 3)->first();
                    $all_task = Task::whereIn('status_id', [4, 5, 21])
                        ->orderBy('tasks.id', 'desc')
                        ->count();

                    // $all_task->load('instruction.contract.client','status','person');
                    $instruction = Instruction::whereIn('status_id', [4, 5, 21])
                        ->with('tasks')
                        ->whereHas('tasks', function ($query) {
                            $query->whereIn('status_id', [4, 5, 21]);
                        })
                        ->count();
                    $service = Service::count();
                    $client = Client::count();
                    $people = Person::where('level_id', '<', '6')->get();
                    $logs = log::orderBy('created_at', 'desc')->limit(10)->get();
                    $task = Task::count();
                    $contract = Contract::count();

                    return view('welcome', compact(
                        'client',
                        'contract',
                        'instruction',
                        'task',
                        'all_task',
                        'service',
                        'logs',
                        'people',
                        'task'
                    ));
                }

                switch ($user->person->department_id) {
                    case 1: //finance
                        $department = Department::where('id', '=', 3)->first();
                        $all_task = Task::whereIn(
                            'status_id',
                            [4, 5, 21]
                        )->orderBy('tasks.id', 'desc')
                            ->count();
                        $instruction = Instruction::whereIn(
                            'status_id',
                            [4, 5, 21]
                        )->with('tasks')
                            ->whereHas(
                                'tasks',
                                function ($query) {
                                    $query->whereIn('status_id', [4, 5, 21]);
                                }
                            )->count();
                        $service = Service::count();
                        $client = Client::whereHas('instructions', function ($query) {
                            $query->whereHas('tasks', function ($q) {
                                $q->whereIn('status_id', [4, 5, 21]);
                            });
                        })
                            ->count();
                        $people = Person::where('level_id', '<', '6')->get();

                        return view(
                            'dashboard.finance',
                            compact('client', 'service', 'people', 'instruction', 'all_task')
                        );
                        break;

                    case 2: //tech
                        $department = Department::where('id', '=', 3)->first();
                        $all_task = Task::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->whereIn('status_id', [4, 5, 21])
                            ->orderBy('tasks.id', 'desc')
                            ->get();
                        $all_task->load('instruction.contract.client', 'status', 'people');
                        $projectCount = Project::whereHas('checklist', function ($qry) use ($user) {
                            $qry->whereHas('people', function ($q) use ($user) {
                                $q->where('person_id', '=', $user->person->id);
                            });
                        })
                            ->count();

                        $checklists = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->whereIn('status_id', [4, 5, 21])
                            ->orderBy('checklists.id', 'desc')
                            ->get();

                        $check_all_list = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            // ->whereIn('status_id', [4, 5, 21])
                            // ->orderBy('checklists.id', 'desc')
                            ->get();
                        $checklists->load('project', 'status', 'people');

                        $total_checklist = $checklists->count();
                        $completed_checklist = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })->where([
                            ['status_id', '=', 7]
                        ])->count();
                        $pending_checklist = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->where([
                                ['status_id', '=', 4]
                            ])->count();
                        $ongoing_checklist = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->where([
                                ['status_id', '=', 5]
                            ])->count();
                        $pending_percent = ($total_checklist) ? ($pending_checklist / $total_checklist) * 100 : 0;
                        $ongoing_percent = ($total_checklist) ? ($ongoing_checklist / $total_checklist) * 100 : 0;
                        $completed_percent = ($total_checklist) ? (100 - ($pending_percent + $ongoing_percent)) : 0;
                        $instructionCount = Instruction::whereIn('status_id', [4, 5, 21])
                            ->with('tasks')
                            ->whereHas('tasks', function ($query) use ($user) {
                                $query->whereHas('people', function ($q) use ($user) {
                                    $q->where('person_id', '=', $user->person->id);
                                });
                            })
                            ->count();
                        // $completed_percent = ($total_checklist) ? ($completed_task / $total_checklist) * 100 : 0;
                        return view(
                            'dashboard.tech',
                            compact(
                                'checklists',
                                'total_checklist',
                                'completed_checklist',
                                'ongoing_checklist',
                                'pending_checklist',
                                'pending_percent',
                                'ongoing_percent',
                                'completed_percent',
                                'instructionCount',
                                'projectCount',
                                'all_task'
                            )
                        );
                        break;

                    case 3: //professionals
                        $department = Department::where('id', '=', 3)->first();
                        $all_task = Task::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->whereIn('status_id', [4, 5, 21])
                            ->orderBy('tasks.id', 'desc')
                            ->get();
                        $all_task->load('instruction.contract.client', 'status', 'people');

                        $instructionCount = Instruction::whereIn('status_id', [4, 5, 21])
                            ->with('tasks')
                            ->whereHas('tasks', function ($query) use ($user) {
                                $query->whereHas('people', function ($q) use ($user) {
                                    $q->where('person_id', '=', $user->person->id);
                                });
                            })
                            ->count();

                        $clientCount = Client::whereHas('instructions', function ($query) use ($user) {
                            $query->whereHas('tasks', function ($qry) use ($user) {
                                $qry->whereHas('people', function ($q) use ($user) {
                                    $q->where('person_id', '=', $user->person->id);
                                });
                            });
                        })
                            ->count();

                        $total_task = $all_task->count();

                        $completed_task = Task::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })->where([
                            ['status_id', '=', 7]
                        ])->count();
                        $pending_task = Task::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->where([
                                ['status_id', '=', 4]
                            ])->count();
                        $ongoing_task = Task::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->where([
                                ['status_id', '=', 5]
                            ])->count();
                        $pending_percent = ($total_task) ? ($pending_task / $total_task) * 100 : 0;
                        $ongoing_percent = ($total_task) ? ($ongoing_task / $total_task) * 100 : 0;
                        $completed_percent = ($total_task) ? ($completed_task / $total_task) * 100 : 0;
                        // $taskPoint = TaskPoint::where('task_id', 12);
                        return view(
                            'dashboard.professionals',
                            compact(
                                // 'client',
                                'user',
                                // 'instruction',
                                // 'task',
                                'all_task',
                                'total_task',
                                'completed_task',
                                'ongoing_task',
                                'pending_task',
                                'pending_percent',
                                'ongoing_percent',
                                'completed_percent',
                                'instructionCount',
                                'clientCount'
                            )
                        );
                        break;

                    case 4: //operations
                        $instruction = Instruction::whereIn(
                            'status_id',
                            [4, 5, 21]
                        )->with('tasks')
                            ->whereHas(
                                'tasks',
                                function ($query) {
                                    $query->whereIn('status_id', [4, 5, 21]);
                                }
                            )->count();
                        $client = Client::whereHas('instructions', function ($query) {
                            $query->whereHas('tasks', function ($q) {
                                $q->whereIn('status_id', [4, 5, 21]);
                            });
                        })->count();
                        $task = Task::count();
                        $service = Service::count(); //$service was not defined
                        $contract = Contract::count();
                        $people = Person::where('level_id', '<', '6')->get();
                        $logs = Log::get();
                        return view('welcome', compact('client', 'contract', 'instruction', 'task', 'service', 'logs', 'people'));
                        break;
                    case 5: //business dev
                        $department = Department::where('id', '=', 3)->first();
                        $all_task = Task::whereIn('status_id', [4, 5, 21])
                            ->orderBy('tasks.id', 'desc')
                            ->count();
                        // $all_task->load('instruction.contract.client','status','person');
                        $instruction = Instruction::whereIn('status_id', [4, 5, 21])
                            ->with('tasks')
                            ->whereHas('tasks', function ($query) {
                                $query->whereIn('status_id', [4, 5, 21]);
                            })
                            ->count();
                        $service = Service::count();
                        $client = Client::whereHas('instructions', function ($query) {
                            $query->whereHas('tasks', function ($q) {
                                $q->whereIn('status_id', [4, 5, 21]);
                            });
                        })
                            ->count();
                        $people = Person::where('level_id', '<', '6')->get();
                        return view('dashboard.sale_&_biz', compact('client', 'service', 'people', 'instruction', 'all_task'));
                        break;
                    case 6: // Partner
                        $instruction = Instruction::whereIn(
                            'status_id',
                            [4, 5, 21]
                        )->with('tasks')
                            ->whereHas(
                                'tasks',
                                function ($query) {
                                    $query->whereIn('status_id', [4, 5, 21]);
                                }
                            )->count();
                        $client = Client::whereHas('instructions', function ($query) {
                            $query->whereHas('tasks', function ($q) {
                                $q->whereIn('status_id', [4, 5, 21]);
                            });
                        })->count();
                        $task = Task::count();
                        $service = Service::count(); //$service was not defined
                        $contract = Contract::count();
                        $people = Person::where('level_id', '<', '6')->get();
                        dd($people);
                        $logs = Log::get();
                        return view('welcome', compact('client', 'contract', 'instruction', 'task', 'service', 'people', 'logs'));
                        break;
                        /* Work in progress */
                    case 7: // DSS 
                        $department = Department::where('id', '=', 7)->first();
                        $all_task = Task::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->whereIn('status_id', [4, 5, 21])
                            ->orderBy('tasks.id', 'desc')
                            ->get();
                        $all_task->load('instruction.contract.client', 'status', 'people');
                        $projectCount = Project::whereHas('checklist', function ($qry) use ($user) {
                            $qry->whereHas('people', function ($q) use ($user) {
                                $q->where('person_id', '=', $user->person->id);
                            });
                        })
                            ->count();

                        $checklists = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->whereIn('status_id', [4, 5, 21])
                            ->orderBy('checklists.id', 'desc')
                            ->get();

                        $check_all_list = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            // ->whereIn('status_id', [4, 5, 21])
                            // ->orderBy('checklists.id', 'desc')
                            ->get();
                        $checklists->load('project', 'status', 'people');

                        $total_checklist = $checklists->count();
                        $completed_checklist = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })->where([
                            ['status_id', '=', 7]
                        ])->count();
                        $pending_checklist = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->where([
                                ['status_id', '=', 4]
                            ])->count();
                        $ongoing_checklist = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->where([
                                ['status_id', '=', 5]
                            ])->count();
                        $pending_percent = ($total_checklist) ? ($pending_checklist / $total_checklist) * 100 : 0;
                        $ongoing_percent = ($total_checklist) ? ($ongoing_checklist / $total_checklist) * 100 : 0;
                        $completed_percent = ($total_checklist) ? (100 - ($pending_percent + $ongoing_percent)) : 0;
                        $instructionCount = Instruction::whereIn('status_id', [4, 5, 21])
                            ->with('tasks')
                            ->whereHas('tasks', function ($query) use ($user) {
                                $query->whereHas('people', function ($q) use ($user) {
                                    $q->where('person_id', '=', $user->person->id);
                                });
                            })
                            ->count();
                        // $completed_percent = ($total_checklist) ? ($completed_task / $total_checklist) * 100 : 0;
                        return view(
                            'dashboard.dss',
                            compact(
                                'checklists',
                                'total_checklist',
                                'completed_checklist',
                                'ongoing_checklist',
                                'pending_checklist',
                                'pending_percent',
                                'ongoing_percent',
                                'completed_percent',
                                'instructionCount',
                                'projectCount',
                                'all_task'
                            )
                        );
                        break;

                    case 8: //HR
                        $department = Department::where('id', '=', 8)->first();
                        $all_task = Task::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->whereIn('status_id', [4, 5, 21])
                            ->orderBy('tasks.id', 'desc')
                            ->get();
                        $all_task->load('instruction.contract.client', 'status', 'people');
                        $projectCount = Project::whereHas('checklist', function ($qry) use ($user) {
                            $qry->whereHas('people', function ($q) use ($user) {
                                $q->where('person_id', '=', $user->person->id);
                            });
                        })
                            ->count();

                        $checklists = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->whereIn('status_id', [4, 5, 21])
                            ->orderBy('checklists.id', 'desc')
                            ->get();

                        $check_all_list = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            // ->whereIn('status_id', [4, 5, 21])
                            // ->orderBy('checklists.id', 'desc')
                            ->get();
                        $checklists->load('project', 'status', 'people');

                        $total_checklist = $checklists->count();
                        $completed_checklist = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })->where([
                            ['status_id', '=', 7]
                        ])->count();
                        $pending_checklist = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->where([
                                ['status_id', '=', 4]
                            ])->count();
                        $ongoing_checklist = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->where([
                                ['status_id', '=', 5]
                            ])->count();
                        $pending_percent = ($total_checklist) ? ($pending_checklist / $total_checklist) * 100 : 0;
                        $ongoing_percent = ($total_checklist) ? ($ongoing_checklist / $total_checklist) * 100 : 0;
                        $completed_percent = ($total_checklist) ? (100 - ($pending_percent + $ongoing_percent)) : 0;
                        $instructionCount = Instruction::whereIn('status_id', [4, 5, 21])
                            ->with('tasks')
                            ->whereHas('tasks', function ($query) use ($user) {
                                $query->whereHas('people', function ($q) use ($user) {
                                    $q->where('person_id', '=', $user->person->id);
                                });
                            })
                            ->count();
                        return view(
                            'dashboard.hr',
                            compact(
                                'checklists',
                                'total_checklist',
                                'completed_checklist',
                                'ongoing_checklist',
                                'pending_checklist',
                                'pending_percent',
                                'ongoing_percent',
                                'completed_percent',
                                'instructionCount',
                                'projectCount',
                                'all_task'
                            )
                        );
                        break;

                    case 9: // Intel & Comms
                        $department = Department::where('id', '=', 9)->first();
                        $all_task = Task::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->whereIn('status_id', [4, 5, 21])
                            ->orderBy('tasks.id', 'desc')
                            ->get();
                        $all_task->load('instruction.contract.client', 'status', 'people');
                        $projectCount = Project::whereHas('checklist', function ($qry) use ($user) {
                            $qry->whereHas('people', function ($q) use ($user) {
                                $q->where('person_id', '=', $user->person->id);
                            });
                        })
                            ->count();

                        $checklists = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->whereIn('status_id', [4, 5, 21])
                            ->orderBy('checklists.id', 'desc')
                            ->get();

                        $check_all_list = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            // ->whereIn('status_id', [4, 5, 21])
                            // ->orderBy('checklists.id', 'desc')
                            ->get();
                        $checklists->load('project', 'status', 'people');

                        $total_checklist = $checklists->count();
                        $completed_checklist = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })->where([
                            ['status_id', '=', 7]
                        ])->count();
                        $pending_checklist = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->where([
                                ['status_id', '=', 4]
                            ])->count();
                        $ongoing_checklist = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->where([
                                ['status_id', '=', 5]
                            ])->count();
                        $pending_percent = ($total_checklist) ? ($pending_checklist / $total_checklist) * 100 : 0;
                        $ongoing_percent = ($total_checklist) ? ($ongoing_checklist / $total_checklist) * 100 : 0;
                        $completed_percent = ($total_checklist) ? (100 - ($pending_percent + $ongoing_percent)) : 0;
                        $instructionCount = Instruction::whereIn('status_id', [4, 5, 21])
                            ->with('tasks')
                            ->whereHas('tasks', function ($query) use ($user) {
                                $query->whereHas('people', function ($q) use ($user) {
                                    $q->where('person_id', '=', $user->person->id);
                                });
                            })
                            ->count();
                        // $completed_percent = ($total_checklist) ? ($completed_task / $total_checklist) * 100 : 0;
                        return view(
                            'dashboard.intel_&_comms',
                            compact(
                                'checklists',
                                'total_checklist',
                                'completed_checklist',
                                'ongoing_checklist',
                                'pending_checklist',
                                'pending_percent',
                                'ongoing_percent',
                                'completed_percent',
                                'instructionCount',
                                'projectCount',
                                'all_task'
                            )
                        );
                        break;

                    case 10: // Logistics
                        $department = Department::where('id', '=', 10)->first();
                        $all_task = Task::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->whereIn('status_id', [4, 5, 21])
                            ->orderBy('tasks.id', 'desc')
                            ->get();
                        $all_task->load('instruction.contract.client', 'status', 'people');
                        $projectCount = Project::whereHas('checklist', function ($qry) use ($user) {
                            $qry->whereHas('people', function ($q) use ($user) {
                                $q->where('person_id', '=', $user->person->id);
                            });
                        })
                            ->count();

                        $checklists = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->whereIn('status_id', [4, 5, 21])
                            ->orderBy('checklists.id', 'desc')
                            ->get();

                        $check_all_list = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            // ->whereIn('status_id', [4, 5, 21])
                            // ->orderBy('checklists.id', 'desc')
                            ->get();
                        $checklists->load('project', 'status', 'people');

                        $total_checklist = $checklists->count();
                        $completed_checklist = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })->where([
                            ['status_id', '=', 7]
                        ])->count();
                        $pending_checklist = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->where([
                                ['status_id', '=', 4]
                            ])->count();
                        $ongoing_checklist = Checklist::whereHas('people', function ($q) use ($user) {
                            $q->where('person_id', '=', $user->person->id);
                        })
                            ->where([
                                ['status_id', '=', 5]
                            ])->count();
                        $pending_percent = ($total_checklist) ? ($pending_checklist / $total_checklist) * 100 : 0;
                        $ongoing_percent = ($total_checklist) ? ($ongoing_checklist / $total_checklist) * 100 : 0;
                        $completed_percent = ($total_checklist) ? (100 - ($pending_percent + $ongoing_percent)) : 0;
                        $instructionCount = Instruction::whereIn('status_id', [4, 5, 21])
                            ->with('tasks')
                            ->whereHas('tasks', function ($query) use ($user) {
                                $query->whereHas('people', function ($q) use ($user) {
                                    $q->where('person_id', '=', $user->person->id);
                                });
                            })
                            ->count();
                        // $completed_percent = ($total_checklist) ? ($completed_task / $total_checklist) * 100 : 0;
                        return view(
                            'dashboard.logistics',
                            compact(
                                'checklists',
                                'total_checklist',
                                'completed_checklist',
                                'ongoing_checklist',
                                'pending_checklist',
                                'pending_percent',
                                'ongoing_percent',
                                'completed_percent',
                                'instructionCount',
                                'projectCount',
                                'all_task'
                            )
                        );
                        break;

                    default:
                        abort(404);
                        break;
                }
                break;

            case 3: //user is an admin
                $client = Client::count();
                $contract = Contract::count();
                $instruction = Instruction::count();
                $task = Task::count();
                $all_task = Task::count();  //Note: it was named $task
                $service = Service::count(); //$service was not defined
                $people = Person::where('level_id', '<', '3');
                $logs = Log::get();
                return view('welcome', compact('logs', 'people', 'client', 'contract', 'instruction', 'task', 'service'));
                break;
            default:
                abort(404);
                break;
        }
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
