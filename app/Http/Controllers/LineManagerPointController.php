<?php

namespace App\Http\Controllers;

use App\Notifications\TaskPointNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskPoint;
use App\Models\Person;


class LineManagerPointController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('LineManager');
    // }

    public function store(Request $request)
    {
        if (Auth::user()->person->level_id >= 1) {

            $request->validate([
                'taskId' => 'required',
                'point' => 'required|integer',
            ]);

            $task = TaskPoint::where('task_id', $request->taskId)->first();

            if ($task) {
                $task->line_manager_point = $request->point;
                $task->task_id = $request->taskId;
                $task->person_id = $request->executorId;
                // $task->save();
            } else {
                $task = new TaskPoint();

                $task->line_manager_point = $request->point;
                $task->task_id = $request->taskId;
                $task->person_id = $request->executorId;
            }

            $task->save();

            $executor = Person::where('id', $request->executorId)->first();

            // Notification::send($executor->user, new TaskPointNotification($task));

            return redirect()->back()->with('status', toastReturnUpdate(
                'Line Manager Point Awarded.',
                'success',
                'Success'
            ));
        }
    }
}
