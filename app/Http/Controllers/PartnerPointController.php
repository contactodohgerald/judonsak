<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskPoint;
use Illuminate\Support\Facades\Auth;
use App\DepartmentPartner;
use App\Models\Person;



class PartnerPointController extends Controller
{
    public function store(Request $request)
    {
        if (Auth::user()->person->level_id > 3 && Auth::user()->person->department_id === (int)$request->departmentId) {

            $designatedPartner = new DepartmentPartner();

            $designatedPartner->department_id = Auth::user()->person->department_id;
            $designatedPartner->partner_id = Auth::user()->id;
            $designatedPartner->save();

            $request->validate([
                'taskId' => 'required',
                'point' => 'required|integer',
                'description' => 'required|string'
            ]);

            $task = TaskPoint::where('task_id', $request->taskId)->first();

            // dd($task->partners_point);

            if ($task) {
                $task->partners_point = $request->point;
                $task->description = $request->description;
                $task->task_id = $request->taskId;
                $task->task_name = $request->taskName;
                $task->instruction_name = $request->instructionName;
                $task->person_id = $request->executorId;
            } else {
                $task = new TaskPoint();

                $task->partners_point = $request->point;
                $task->description = $request->description;
                $task->task_id = $request->taskId;
                $task->task_name = $request->taskName;
                $task->instruction_name = $request->instructionName;
                $task->person_id = $request->executorId;
            }

            $task->save();

            // $executor = Person::where('id', $request->executorId)->first();

            // Notification::send($executor->user, new TaskPointNotification($task));

            // $this->sendTaskPointMail($executor->user, $task);

            return redirect()->back()->with('status', toastReturnUpdate(
                'Partner Point Awarded',
                'success',
                'Success'
            ));
        } else {
            abort(403, 'Executor is not in your department');
        }
    }
}
