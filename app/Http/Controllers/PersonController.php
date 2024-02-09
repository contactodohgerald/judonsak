<?php

namespace App\Http\Controllers;

use App\{Level, User};
use App\Models\{Client, Department, GeneralPoint, Instruction, Log, Person, Task, TaskPoint};
use Generator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PersonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('hr', ['only' => [
            'create',
            'edit',
            'store',
            'update',
        ]]);

        // $this->middleware('partners')
        //     ->only([
        //         'create',
        //         'edit',
        //         'store',
        //     ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|Application|Response|View
     */
    public function index()
    {
        $people = Person::with('department', 'user')
            ->orderBy('id', 'asc')
            ->get();

        return view('profile.index', compact('people'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $levels = Level::all();
        $departments = Department::all();
        return view('profile.create', compact('levels', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // if (Auth::user()->person->level_id < 5)
        //     abort(403, 'Unauthorized Action');

        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|max:255|',
            'department' => 'required|integer',
            'level' => 'required|integer',
            'staffId' => 'required',
            'profile_image' => 'nullable'
        ]);

        // Create New Staff
        $user = new User;
        $user->name = $request->firstname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $name = Str::slug($request->firstname) . '.' . $image->getClientOriginalExtension();
            // $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('images');
            $image->move($destinationPath, $name);
            $user->profile_image = $name;
            // $user->profile_image = $destinationPath;
        }

        $user->save();

        // save the person
        $person = new Person;
        $person->first_name = $request->firstname;
        $person->last_name = $request->lastname;
        $person->department_id = $request->department;
        $person->level_id = $request->level;
        $person->state_id = 25;
        $person->phone_num = $request->phone;
        $person->staff_id = $request->staffId;
        $user->person()->save($person);

        // create event here instead...
        // Mail::to($user->email)->send(new StaffCreated($user)); Olamide commented this

        return redirect()->route('profile.index')
            ->with('status', toastReturnUpdate(
                'Action Successful',
                'success',
                'Success'
            ));
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Person $person
     * @return Response
     */
    public function show(Person $profile)
    {
        if (Auth::user()->id === $profile->user_id || (Auth::user()->person->level_id > 3 || Auth::user()->person->department_id === 8)) {

            $user = User::where('id', $profile->user_id)->first();
            $department = Department::find($profile->department->id);
            $tasks = Task::whereHas('people', function ($q) use ($profile) {
                $q->where('person_id', '=', $profile->id);
            })
                ->whereIn('status_id', [4, 5, 21])
                ->orderBy('tasks.id', 'desc')
                ->get();
            $tasks->load('instruction.contract.client', 'status', 'people');

            $logs = Log::where('person_id', '=', $profile->id)
                ->orderBy('created_at', 'desc')
                ->limit(6)
                ->get()
                ->load('person.user');

            $clients = Client::whereHas('instructions', function ($query) use ($profile) {
                $query->whereHas('tasks', function ($q) use ($profile) {
                    $q->whereHas('people', function ($filter) use ($profile) {
                        $filter->where([['person_id', '=', $profile->id]]);
                    })
                        ->whereIn('status_id', [4, 5, 21]);
                });
            })
                ->get();

            $instructions = Instruction::whereIn('status_id', [4, 5, 21])
                ->with('tasks')
                ->whereHas('tasks', function ($query) use ($profile) {
                    $query->whereHas('people', function ($q) use ($profile) {
                        $q->where('person_id', '=', $profile->id);
                    })
                        ->whereIn('status_id', [4, 5, 21]);
                })
                ->get();

            $profile->load('department');

            /* Task Point */
            $tasks = Task::where('executor_id', $profile->id)->get();
            $lineManagerPoint = $partnerPoint = 0;
            foreach ($tasks as $task) {
                if ($task->taskPoint) {
                    $lineManagerPoint += $task->taskPoint->line_manager_point;
                    $partnerPoint += $task->taskPoint->partners_point;
                }
            }

            // Do for year too.
            $hrPoint = GeneralPoint::where('person_id', $profile->id)
                ->where('hr_point', '!=', null)
                ->sum('hr_point');


            /* Executor Task */
            $userTask = Task::where('executor_id', $profile->id)->get();
            $totalTask = count($userTask);

            /* Total Point */
            $totalPoint = $lineManagerPoint + $partnerPoint + $hrPoint;

            return view('profile.show', compact(
                'logs',
                'user',
                'tasks',
                'instructions',
                'clients',
                'profile',
                'department',
                'partnerPoint',
                'lineManagerPoint',
                'hrPoint',
                'totalTask',
                'totalPoint'
            ));
        } else {
            abort(403, 'Unauthorized Action');
        }
    }


    /*
     *
     * PartnerPointDetails
     *
     */
    public function partnerPointDetails($personId)
    {
        if (Auth::user()->person->id = $personId || (Auth::user()->person->level_id > 3 || Auth::user()->person->department_id === 8)) {
            $person = Person::find($personId);

            $points = TaskPoint::where('person_id', $personId)->get();

            return view("profile.partner_point_details", compact('points'));
        }
    }

    /*
    * lineManagerPointDetails
    */
    public function linemanagerPointDetails($personId)
    {
        if (Auth::user()->person->id = $personId || (Auth::user()->person->level_id > 3 || Auth::user()->person->department_id === 8)) {
            $person = Person::find($personId);

            $points = TaskPoint::where('person_id', $personId)->get();

            return view("profile.linemanagerPointDetails", compact('points'));
        }
    }

    /* 
    *
    * HRPoint
    *
    */
    public function hrPoint($personId)
    {
        if (Auth::user()->person->id = $personId || (Auth::user()->person->level_id > 3 || Auth::user()->person->department_id === 8)) {
            $person = Person::find($personId);

            $points = GeneralPoint::where('person_id', $personId)->get();

            return view("profile.hrpoint_details", compact('points'));
        }
    }


    /*
    *
    * TotalPoint
    *
    */
    public function totalPoint($personId)
    {

        if (Auth::user()->person->id = $personId || (Auth::user()->person->level_id > 3 || Auth::user()->person->department_id === 8)) {
            $person = Person::find($personId);

            $tasks = TaskPoint::where('person_id', $personId)->get();
            $generalPoints = GeneralPoint::where('person_id', $personId)->get();

            $totalPartnerPoints = $totalLMPoints = 0;
            $totalHrPoint = 0;

            foreach ($tasks as $task) {
                $totalLMPoints += $task->line_manager_point;
                $totalPartnerPoints += $task->partners_point;
            }

            foreach ($generalPoints as $hrPoint) {
                $totalHrPoint += $hrPoint->hr_point;
            }

            $totalPoint = $totalPartnerPoints + $totalLMPoints + $totalHrPoint;

            return view('profile.totalpoint_details', compact(
                'totalPartnerPoints',
                'totalLMPoints',
                'totalHrPoint',
                'totalPoint',
                'tasks'
            ));
        }
    }


    /*
    *
    * TotalTask
    *
    */
    public function totalTask($personId)
    {
        if (Auth::user()->person->id = $personId || (Auth::user()->person->level_id > 3 || Auth::user()->person->department_id === 8)) {
            $person = Person::find($personId);

            $totalTask = Task::where('executor_id', $personId)->get();

            return view('profile.totalTask', compact('totalTask'));
        }
    }


    /*
    *
    * destroy
    *
    */
    public function destroy(Person $profile)
    {
        if (Auth::user()->person->level_id < 5)
            abort(403, 'Unauthorized Action');
        $profile->delete();

        return back()->with('status', toastReturnUpdate(
            'Action Successful',
            'success',
            'Success'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Person $person
     * @return Response
     */
    public function edit(Person $person)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Person $person
     * @return Response
     */
    public function update(Request $request, $profile)
    {

        $person = Person::find($profile);

        $person->first_name = $request->first_name;
        $person->last_name = $request->last_name;
        $person->address = $request->address;
        $person->staff_id = $request->staff_id;
        $person->phone_num = $request->phone_number;
        $person->birth_day = $request->birth_day;

        $person->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Person $person
     * @return Response
     */
}

// private function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
// {
//     $name = !is_null($filename) ? $filename : Str::random(25);

//     $file = $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->getClientOriginalExtension(), $disk);

//     return $file;
// }

// Check if a profile image has been uploaded

// if ($request->has('profile_image')) {
//     /* Get image file */
//     $image = $request->file('profile_image');

//     /* Make a image name based on user name and current timestamp */
//     $name = Str::slug($request->firstname) . "_" . time();

//     /* Define folder path*/
//     $folder = '/uploads/images';

//     // Make a file path where image will be stored [folder path +  file name + file extension]
//     $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();

//     // Upload image
//     $this->uploadOne($image, $folder, 'public', $name);

//     $user->profile_image = $filePath;
// }
