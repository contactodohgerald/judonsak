<?php

namespace App\Http\Controllers;

use App\Models\{Recievable, Feenote, Bank, Cashbook};
use Illuminate\Http\Request;

class RecievableController extends Controller
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
        $banks = Bank::all();
        $recievables = Recievable::orderBy('created_at', 'Desc')
                            ->limit(100)
                            ->get();
        $recievables->load('feenote.client');
        return view('finance.cashbook.feenote.recievables', compact('recievables', 'banks'));

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
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recievable  $recievable
     * @return \Illuminate\Http\Response
     */
    public function show(Recievable $recievable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recievable  $recievable
     * @return \Illuminate\Http\Response
     */
    public function edit(Recievable $recievable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recievable  $recievable
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recievable $recievable)
    {
        $request->validate(
            [
                'client_id' => 'required|integer',
                'subject' => 'required',
                'amount' => 'required',
                'bank_id' => 'required|integer',
            ]
        );
        $payment = $recievable->feenote->payment;
        $expected_amount = (
            ($payment->percent / 100) * $payment->contract->amount);
        $check_paid_feenote = Feenote::where(
            [
                ['payment_id', '=', $payment->id], 
                ['paid', '!=', null]
            ]
        )->sum('paid');
        $check_pending_feenote = Feenote::where(
            [
                ['payment_id', '=', $payment->id], 
                ['paid', '=', null]
            ]
        )->sum('amount');
        $check_feenote = $check_pending_feenote + $check_paid_feenote;
        if ($check_feenote > $expected_amount) {
            return response()->json(
                ['status' => 'error', 'message' => 'Overcharging Error. Edit Contract and Try Again']
            );
        }
        if ($request->amount > $recievable->amount_paid) {
            return response()->json(
                [
                    'status' => 'error', 
                    'message' => 'Your Request Amount is More Than Expected'
                ]
            );            
        }
        // create feenote with neccesary amount
        //  update cashbook
        $feenote = New Feenote;
        $feenote->user_id = \Auth::id();
        $feenote->client_id = $request->client_id;
        $feenote->payment_id = $recievable->feenote->payment_id;
        $feenote->bank_id = $request->bank_id;
        $feenote->amount = $recievable->amount_paid;
        $feenote->subject = $request->subject;
        $feenote->vat = (5/100)*$recievable->amount_paid;//5% of amount;
        $feenote->payable = $feenote->vat + $feenote->amount;
        $feenote->paid = $request->amount;
        $feenote->save();

        // update cashbook
        $cashbook = new Cashbook;
        $cashbook->client_id = $request->client_id;
        $cashbook->bank_id = $request->bank_id;
        $cashbook->currency_id = $payment->contract->currency_id;
        $cashbook->category_id = 1;//corperate
        $cashbook->cashbook_label_id = 3;//revenue
        $cashbook->group_id = 1;//debit
        $cashbook->amount = $request->amount;
        $cashbook->description = $request->subject;
        $cashbook->date = date('Y-m-d');
        $cashbook->save();

        // check if client pays everything.
        if ($request->amount < $recievable->amount_paid) {
            $newRecievable = new Recievable;
            $newRecievable->feenote_id = $recievable->feenote_id;
            $newRecievable->amount_paid = $recievable->amount_paid - $request->amount;//remaining
            $newRecievable->currency_id = $payment->contract->currency_id;
            $newRecievable->balance_date = $request->balance_date ?? null;
            $newRecievable->save();
        }

        return response()->json(
            ['status' => 'success', 'message' => 'Feenote Remmited Successfully']
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recievable  $recievable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recievable $recievable)
    {
        //
    }
}
