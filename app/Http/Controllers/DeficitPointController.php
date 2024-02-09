<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{
    Person,
    Task,
    Log,
    Instruction,
    Client,
    Department,
    GeneralPoint
};

class DeficitPointController extends Controller
{
    public function store(Request $request, Person $profile)
    {

        $deficitPoint = GeneralPoint::where('person_id', $profile->id)->first();

        $request->validate([
            'deficitPoint' => 'required',
        ]);

        if ($deficitPoint) {
            $deficitPoint->deficit_point = $request->deficitPoint;
            $deficitPoint->person_id = $request->personId;
        } else {
            $deficitPoint = new GeneralPoint();

            $deficitPoint->deficit_point = $request->deficitPoint;
            $deficitPoint->person_id = $request->personId;
        }

        $deficitPoint->save();

        return redirect()->back()->with('status', toastReturnUpdate(
            'Action Successfull',
            'success',
            'Success'
        ));

        // return redirect()->back()->with('message', 'Deficit point awarded successfully.');
    }
}
