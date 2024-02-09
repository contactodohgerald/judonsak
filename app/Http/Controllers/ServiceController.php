<?php

namespace App\Http\Controllers;

use App\Models\{ 
    Client, 
    State, 
    Service, 
    Person, 
    Contract, 
    Task, 
    Instruction 
};
use App\User;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Hash;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::orderBy('created_at', 'desc')->get();
        return view('service.index', compact(('services')));

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
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        $service->load( 
            'contracts', 
            'instructions', 
            'tasks'
        )
            ->orderBy('id', 'desc');
        return view('service.show', compact('service'));    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {

    }

    /**
     * Get the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function getClientApi(Service $service)
    {
        return response()->json(
            [
            'cliens' => $service->clients,
            'state' => 'CA'
            ]
        );
    }

    /**
     * Get the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function getInstructionApi(Service $service)
    {
        return response()->json(
            [
            'instructions' => $service->instructions,
            'state' => 'CA'
            ]
        );
    }

    /**
     * Get the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function getTaskApi(Service $service)
    {
        return response()->json(
            [
            'task' => $service->tasks,
            'status' => 'success'
            ]
        );
    }


    /**
     * Get the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function getContractApi(Service $service)
    {
        return response()->json(
            [
            'contracts' => $service->load('contracts.client'),
            'status' => 'success'
            ]
        );
    }

}
