<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{ Revenue, Recievable, Payment, Expenditure};

class RevenueController extends Controller
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
     * @param  \App\Revenue  $revenue
     * @return \Illuminate\Http\Response
     */
    public function show(Revenue $revenue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Revenue  $revenue
     * @return \Illuminate\Http\Response
     */
    public function edit(Revenue $revenue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Revenue  $revenue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Revenue $revenue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Revenue  $revenue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Revenue $revenue)
    {
        //
    }


    /**
     * Show the financial summary og the company.
     *
     * @param  \App\Models\Revenue  $revenue
     * @return \Illuminate\Http\Response
     */
    public function financialSummary()
    {
        $payments = Payment::whereMonth(
            'due_date', '=', \Carbon::now()->addMonth()->month
        )->with('contract')->get();

        $recievables = Recievable::with(
            'feenote.payment.contract'
        )->where(
            'amount_paid', '!=', null 
        )->get();
        $paymentsNGN = $payments->map(
            function ($payment, $index) {
                if ($payment->contract->currency_id == 1 ) {
                    $calcPayment = (
                        ($payment->percent / 100) * $payment->contract->amount
                    );
                    return $calcPayment;
                }
            }
        )->sum();
        $paymentsUSD = $payments->map(
            function ($payment, $index) {
                if ($payment->contract->currency_id == 2 ) {
                    $calcPayment = (
                        ($payment->percent / 100) * $payment->contract->amount
                    );
                    return $calcPayment;
                }
            }
        )->sum();
        $expenditures = Expenditure::where('status_id', 23)->sum('total');
        $bool = (
            $paymentsNGN + $recievables->where(
                'currency_id', 
                '=', 
                1 
            )->sum('amount_paid')) > $expenditures;

        return view(
            'finance.summary', 
            compact(
                'payments', 
                'recievables',
                'paymentsNGN',
                'paymentsUSD',
                'expenditures',
                'bool'
            )
        );
    }
}
