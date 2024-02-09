<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Log,
    Client,
    Contract,
    Instruction,
    Task,
    Person
};

class LogController extends Controller
{
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

    public function getParam($param)
    {
        switch ($param) {
            case 'client':
                $logs = Log::where('logable_type', '=', 'App\Models\Client')->orderBy('created_at', 'desc')->limit(100)->get();
                break;

            case 'contract':
                $logs = Log::where('logable_type', '=', 'App\Models\Contract')->orderBy('created_at', 'desc')->limit(100)->get();
                break;

            case 'instruction':
                $logs = Log::where('logable_type', '=', 'App\Models\Instruction')->orderBy('created_at', 'desc')->limit(100)->get();
                break;

            case 'task':
                $logs = Log::where('logable_type', '=', 'App\Models\Task')->orderBy('created_at', 'desc')->limit(100)->get();
                
                // foreach ($logs as $log) {
                //     dd($log->person->slug);
                // }
                break;

            default:
                abort(404);
                break;
        }
        return view('logs.index', compact('logs'));
    }


    public function Person(Person $person)
    {
        $logs = Log::where('person_id', '=', $person->id)
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get();

        return view('logs.index', compact('logs'));
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
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function show(Log $log)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function edit(Log $log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Log $log)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function destroy(Log $log)
    {
        //
    }
}
