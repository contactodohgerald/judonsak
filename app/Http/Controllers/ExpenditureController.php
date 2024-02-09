<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\{ 
    Expenditure, 
    Expenditure_category, 
    Payment,
    Revenue,
    Recievable,
    Feenote,
    Budget
};

class ExpenditureController extends Controller
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
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function show(Expenditure $expenditure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function edit(Expenditure $expenditure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expenditure $expenditure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expenditure $expenditure, Budget $budget)
    {
        $data = ['message' => 'Rejected Successfully', 'type'=> 'success', 'titl' => 'Success'];
        if($expenditure->status_id == 24) {
            return redirect()->route('budget.show',['budget' => $budget->slug])->with('status', $data);
        }
        // check for permission
        $expenditure->status_id = 24;
        $expenditure->save();

        return redirect()->route('budget.show',['budget' => $budget->slug])->with('status', $data);

    }


    public function upload(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'budget' => 'file|mimes:xlsx,csv,ods',
                'month' => 'required'
            ]
        );
        // create budget
        $budget = new Budget;
        $budget->name  = $request->name;
        $budget->month  = $request->month;
        $budget->save();

        // create Revenue
        $payments = Payment::whereMonth('due_date','=', $request->month)
            ->with('contract')
            ->get();
        $recievables = Recievable::with('feenote.payment.contract')->where('amount_paid', '!=', null)->get();
        $paymentBody = $payments->map(function($payment, $key) use ($budget){
             return [
                'client_id' => $payment->contract->client_id,
                'description' => $payment->contract->client->name,
                'budget_id' => $budget->id,
                'currency_id'  => $payment->contract->currency_id,
                'category_id' => 1,
                'payment_id' => $payment->id,
                'total' => (($payment->percent /100) * $payment->contract->amount),
                'issue_date' => $payment->due_date
            ];
        });
        $recievableBody = $recievables->map(
            function ($recievable, $key) use ($budget) {
                    return [
                        'client_id' => $recievable->feenote->client_id,
                        'description' => $recievable->feenote->subject,
                        'budget_id' => $budget->id,
                        'currency_id'  =>
                        $recievable->feenote->payment->contract->currency_id,
                        'category_id' => 2,
                        'payment_id' => $recievable->id,
                        'total' => $recievable->amount_paid,
                        'issue_date' => $recievable->feenote->payment->due_date
                    ];
            }
        );
        $body = $paymentBody->concat($recievableBody);
        $budget->revenues()->createMany($body->toArray());

        // create Expenditure.
        $collection = (new FastExcel)->import($request->file('budget'));
        if ($collection->count() < 1) {
            return redirect()
                ->route('budget.new')
                ->with(
                    'status', 
                    toastReturnUpdate(
                        $message = 'Empty Data', 
                        $type = 'error', 
                        $title = 'Error'
                    )
                );
        }
        foreach ($collection as $key => $value) {
            // check to see if category exist in the db
            $category  = Expenditure_category::where(
                'name', 
                '=', 
                $value['category']
            )->first();
            if (!$category) {
                $category = new Expenditure_category;
                $category->name = $value['category'];
                $category->save();
            }

            $expenditure = new Expenditure;
            $expenditure->description = $value['description'];
            $expenditure->budget_id = $budget->id;
            $expenditure->expenditure_category_id = $category->id;
            $expenditure->gross = ($value['gross'] != '') ? $value['gross'] : null;
            $expenditure->employer_cost = ($value['employer_cost'] != '') ? $value['employer_cost'] : null;
            $expenditure->total = $value['total_cost'];
            $expenditure->status_id = ($value['status'] == 'Pending') ? 4 : 22;
            $expenditure->save();

        }

        $data = [
            'message' => 'Import Successfull', 
            'type'=> 'success', 
            'titl' => 'Success'
        ];

        return redirect()->route('budget.index')->with('status', $data);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function accept(Expenditure $expenditure, Budget $budget)
    {
        $data = ['message' => 'Update Successfull', 'type'=> 'success', 'titl' => 'Success'];
        if($expenditure->status_id == 23) {
            return redirect()->route('budget.index')->with('status', $data);
        }
        // check for permission
        $expenditure->status_id = 23;
        $expenditure->save();
        return redirect()->route('budget.show',['budget' => $budget->slug])->with('status', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function pend(Expenditure $expenditure, Budget $budget)
    {
        $data = ['message' => 'Update Successfull', 'type'=> 'success', 'titl' => 'Success'];
        if($expenditure->status_id == 4) {
            return redirect()->route('budget.show',['budget' => $budget->slug])->with('status', $data);
        }
        // check for permission
        $expenditure->status_id = 4;
        $expenditure->save();

        return redirect()->route('budget.show',['budget' => $budget->slug])->with('status', $data);
    }


    // private function updateCashbook($expenditure) 
    // {
    //     $cashbook = new Cashbook;

    //     // client_id, bank_id, currency_id, category_id, group_id, amount, description, date.
    // }


}
