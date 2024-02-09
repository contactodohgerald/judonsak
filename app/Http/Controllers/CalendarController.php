<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{ 
    Calendar, 
    Contact
};

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::all();
        $body = [];
        foreach ($contacts as $key => $contact) {
            if ($contact->birthday) {
                $body[] = [
                    'contact_id' => $contact->id, 
                    'name' => 'birthday', 
                    'date' => $contact->birthday
                ];
            }elseif ($contact->anniversary) {
                $body[] = [ 
                    'contact_id' => $contact->id, 
                    'name' => 'anniversary', 
                    'date' => $contact->anniversary];
            }elseif ($contact->others) {
                $body[] = [ 
                    'contact_id' => $contact->id, 
                    'name' => 'others', 
                    'date' => $contact->others];
            }
        }
        $countCalender = Calendar::count();
        if ($countCalender < 1) {
            $calendar = Calendar::insert($body);
        }
        $calendars = Calendar::with('contact')->get();

        return view('calendar.index', compact('calendars'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function show(Calendar $calendar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function edit(Calendar $calendar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calendar $calendar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calendar $calendar)
    {
        //
    }
}
