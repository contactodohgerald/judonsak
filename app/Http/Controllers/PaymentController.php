<?php

namespace App\Http\Controllers;

use App\Models\{Payment, Bank};
use Illuminate\Http\Request;

class PaymentController extends Controller
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
        $payments = Payment::orderBy('created_at', 'Desc')->limit(100)->get();
        dd($payments);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function directQuery($param)
    {
        switch ($param) {
            case 'pending':
                $payments = Payment::where('status_id', '=', 20)
                    ->orderBy('created_at', 'Desc')
                    ->limit(100)
                    ->get();
                $payments->load('contract.client');
                return view('finance.cashbook.payment.pending', compact('payments'));
                break;
            case 'ongoing':
                $payments = Payment::where('status_id', '=', 5)
                    ->orderBy('created_at', 'Desc')
                    ->limit(100)
                    ->get();
                $payments->load('contract.client');
                return view('finance.cashbook.payment.ongoing', compact('payments'));
                break;
            case 'complete':
                $payments = Payment::where('status_id', '=', 7)
                    ->orderBy('created_at', 'Desc')
                    ->limit(100)
                    ->get();
                $payments->load('contract.client');
                return view('finance.cashbook.payment.completed', compact('payments'));
                break;
            case 'overdue':
                $payments = Payment::where('status_id', '=', 6)
                    ->orderBy('created_at', 'Desc')
                    ->limit(100)
                    ->get();
                $payments->load('contract.client');
                return view('finance.cashbook.payment.overdue', compact('payments'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
