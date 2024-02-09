<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendTaskPointMail;
use Illuminate\Support\Facades\Auth;
use App\Models\Person;

use App\Models\{
    GeneralPoint,
};

class HRPointController extends Controller
{
    // BONUS POINT
    public function store(Request $request)
    {
        if (Auth::user()->person->level_id > 3 || Auth::user()->person->department_id === 8) {
            $hrPoint = GeneralPoint::where('person_id', $request->personId)->first();

            $request->validate([
                'hrPoint' => 'required',
                'description' => 'required',
            ]);

            if ($hrPoint) {
                $hrPoint = new GeneralPoint();
                
                $hrPoint->hr_point += $request->hrPoint;
                $hrPoint->description = $request->description;
                $hrPoint->person_id = $request->personId;
                $hrPoint->save();
            } else {
                $point = new GeneralPoint();

                $point->hr_point = $request->hrPoint;
                $point->description = $request->description;
                $point->person_id = $request->personId;
                $point->save();
            }


            return redirect()->back()->with('status', toastReturnUpdate(
                'HR Point Awarded',
                'success',
                'Success'
            ));
        }
    }
}
