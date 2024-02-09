<?php

namespace App\Http\Controllers;

use App\Models\{Feenote, Payment, Recievable, Cashbook, Bank};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeenoteController extends Controller
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
        //
    }

    public function directQuery($param)
    {
        $banks = Bank::all();
        switch ($param) {
            case 'pending':
                $feenotes = Feenote::where('payable', '=', null)
                    ->orderBy('created_at', 'Desc')
                    ->limit(100)
                    ->get();
                $feenotes->load('payment.contract');
                return view('finance.cashbook.feenote.index', compact('feenotes', 'banks'));

                break;

            case 'paid':
                $feenotes = Feenote::where('payable', '!=', null)
                    ->orderBy('created_at', 'Desc')
                    ->limit(100)
                    ->get();
                $feenotes->load('payment.contract');
                return view('finance.cashbook.feenote.paid', compact('feenotes', 'banks'));
                break;

            default:
                abort(404);
                break;
        }
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
        $request->validate(
            [
                'subject' => 'required',
                'client_id' => 'required|integer',
                'payment_id' => 'required',
                'amount' => 'required',
                'bank_id' => 'required'
            ]
        );

        /*** 
            Check if payment has been fully paid        
            so no need to create new feeenote
         **/

        $payment = Payment::where('id', '=', $request->payment_id)->first();
        $check_paid_feenote = Feenote::where(
            [
                ['payment_id',  '=', $payment->id],
                ['paid', '!=', null]
            ]
        )->sum('paid');
        $check_pending_feenote = Feenote::where(
            [
                ['payment_id', '=', $payment->id],
                ['paid', '=', null]
            ]
        )->sum('amount');
        $check_feenote_sum = $check_pending_feenote + $check_paid_feenote;

        $expected_amount = (
            ($payment->percent / 100) * $payment->contract->amount);

        if ($check_feenote_sum > $expected_amount) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Overcharging Error. Edit Contract and Try Again'
                ]
            );
        }

        $feenote = new Feenote;
        $feenote->user_id = Auth::id();
        $feenote->client_id = $request->client_id;
        $feenote->payment_id = $request->payment_id;
        $feenote->bank_id = $request->bank_id;
        $feenote->amount = $request->amount;
        $feenote->subject = $request->subject;
        $feenote->vat = (5 / 100) * $request->amount; //5% of amount;
        $feenote->payable = $feenote->vat + $feenote->amount;
        $feenote->save();

        // update payment status to ongoing
        $payment->status_id = 5;
        $payment->save();

        // create a recievable if Admin is not genrating full amount of payment
        if ($feenote->amount < $expected_amount) {
            $recievable = new Recievable;
            $recievable->feenote_id = $feenote->id;
            $recievable->amount_paid = $request->amount_paid;
            $recievable->currency_id = $payment->contract->currency_id;
            $recievable->balance_date = $request->balance_date ?? null;
            $recievable->save();
        }

        return response()->json(
            ['status' => 'success', 'message' => 'Feenote Generated Successfully']
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feenote  $feenote
     * @return \Illuminate\Http\Response
     */
    public function show(Feenote $feenote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feenote  $feenote
     * @return \Illuminate\Http\Response
     */
    public function edit(Feenote $feenote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feenote  $feenote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feenote $feenote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feenote  $feenote
     * @return \Illuminate\Http\Response
     */
    public function remit(Request $request, Feenote $feenote)
    {
        $request->validate(
            [
                'client_id' => 'required',
                'amount' => 'required',
                'subject' => 'required|min:2',
                'feenote_id' => 'required',
                'bank_id' => 'required'
            ]
        );

        // check if someone is messing with inspect element
        if ($request->client_id != $feenote->client_id) {
            return response()->json(
                ['error' => 'error', 'message' => 'Clients Do Not Match']
            );
        }
        $feenote->paid = $request->amount;
        $feenote->save();

        /** 
         *  Create a recievable if amount expected is not the same as 
         * the amount paid.
         * */
        if ($request->amount < $feenote->payable) {
            $recievable = new Recievable;
            $recievable->feenote_id = $feenote->id;
            $recievable->amount_paid = $feenote->payable - $request->amount;
            $recievable->currency_id = $feenote->payment->contract->currency_id;
            $recievable->balance_date = $request->balance_date ?? null;
            $recievable->save();
        }

        // Record Transaction To CashBook.
        $cashbook = new Cashbook;
        $cashbook->client_id = $feenote->client_id;
        $cashbook->bank_id = $feenote->bank_id;
        $cashbook->currency_id = $feenote->payment->contract->currency_id;
        $cashbook->category_id = 1; //corperate
        $cashbook->cashbook_label_id = 3; //revenue
        $cashbook->group_id = 1; //debit
        $cashbook->amount = $request->amount;
        $cashbook->description = $request->subject;
        $cashbook->date = date('Y-m-d');
        $cashbook->save();

        return response()->json(
            ['status' => 'success', 'message' => 'Feenote Remmited Successfully']
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feenote  $feenote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feenote $feenote)
    {
        //
    }
}
