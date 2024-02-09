<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Budget, 
    Expenditure,
    Expenditure_category, 
    Wage, 
    Operation, 
    Bdm, 
    Recievable,
    Payment,
    Investment, 
    Currency, 
    Revenue,
    Status
};

class BudgetController extends Controller
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
        $budgets = Budget::with('expenditures')->get();
        return view('finance.budget.index', compact('budgets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = Status::all();
        $budget = null;
        $categories = Expenditure_category::all();
        $count = 0;
        return view(
            'finance.budget.create', 
            compact(
                'statuses', 
                'budget',
                'categories', 
                'count'
            )
        );
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
                'month' => 'required',
                'name' => 'required',
                'description' => 'required|array',
                'gross' => 'nullable|array',
                'employers' => 'nullable|array',
                'total' => 'required|array',
                'category_id' => 'required|array',
            ]
        );
        $budget = new Budget;
        $budget->name = $request->name;
        $budget->month = $request->month;
        $budget->save();

        $body = [];
        $count = count($request->total);
        for ($i=0; $i < $count; $i++) { 
            $body[$i] = [
               'description' => $request->description[$i],
               'gross' => $request->gross[$i],
               'employer_cost' => $request->employers[$i],
               'expenditure_category_id' => $request->category_id[$i],
               'total' => $request->total[$i],
               'status_id' => 4
            ];
        }
        $budget->expenditures()->createMany($body);
        return redirect()
            ->route(
                'budget.show', 
                ['budget' => $budget->slug]
            );

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function show(Budget $budget)
    {
        $budget->load('expenditures', 'revenues', 'status');
        $categories = Expenditure_category::all();
        return view('finance.budget.show', compact('budget', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function edit(Budget $budget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Budget $budget)
    {
        $expenditure = new Expenditure;
        $expenditure->description = $request->description;
        $expenditure->gross = $request->gross;
        $expenditure->employer_cost = $request->employers;
        $expenditure->expenditure_category_id = $request->category_id;
        $expenditure->total = $request->total;
        $expenditure->status_id = 4;
        $expenditure->budget_id = $budget->id;
        $expenditure->save();

        return redirect()
            ->route('budget.show', ['budget'=> $budget->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function destroy(Budget $budget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function accept(Budget $budget)
    {
        if(\Auth::user()->person->lever_id < 6)
            abort(403);

        $budget->verified = date('Y-m-s H i s');
        $budget->save();
        return redirect()->back()->with(
            'status', toastReturnUpdate( 
                'Action Successfull', 
                'success', 
                'Success'
            )
        );
    }


}
