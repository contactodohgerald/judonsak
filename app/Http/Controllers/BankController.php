<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function __construct()
    {
        $this->middleware('finance');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::orderBy('name', 'asc')->get();
        return view('finance.bank.index', compact(('banks')));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banks = Bank::orderBy('name', 'asc')->get();
        return view('finance.bank.index', compact(('banks')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name'  => 'required',
                'label' => 'required',
                'account' => 'required',
                'balance' => 'required',
                'currency' => 'required',
                'officer'  => 'nullable',
                'officer_number' => 'nullable',
                'officer_email'  => 'nullable'
            ]
        );

        $bank = new Bank;
        $bank->name  = $request->name;
        $bank->label = $request->label;
        $bank->acc_number = $request->account;
        $bank->balance = $request->balance;
        $bank->currency_id = $request->currency;
        $bank->acc_officer = $request->officer;
        $bank->acc_officer_number = $request->officer_number;
        $bank->acc_officer_email = $request->officer_email;

        $bank->save();
        return response()->json(
            ['status' => 'success', 'message' => 'Bank Creatted Successfully']
        );

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
        $request->validate(
            [
                'officer' => 'required',
                'officer_number' => 'nullable',
                'officer_email' => 'nullable'
            ]
        );

        $bank->acc_officer = $request->officer;
        $bank->acc_officer_number = $request->officer_number;
        $bank->acc_officer_email = $request->officer_email;
        $bank->save();

        return response()->json(
            [ 
                'status' => 'success', 
                'message' => 'Balance Updated Successfully'
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        //
    }
}
