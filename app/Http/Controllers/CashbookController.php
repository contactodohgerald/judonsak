<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{ 
    Cashbook, 
    Client, 
    Currency, 
    Cashbook_label, 
    Bank
};

class CashbookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('finance');
    }

    public function index()
    {
        $thisMonth = intval(date('m'));
        $lastMonth = \Carbon::now()->subMonth()->month;// use carbon because of datetime issues with last month.
        $banks = Bank::with('cashbooks')->get();
        $cashbooks = Cashbook::whereMonth(
            'date', '>=', 
            $thisMonth
        )->get();

        $debits = Cashbook::whereMonth(
            'date', '>=', 
            $thisMonth
        )
        ->where('group_id', '=', 1)
        ->get();

        $credits = Cashbook::whereMonth(
            'date', '>=', 
            $thisMonth
        )->where('group_id', '=', 2)
        ->get();

        $corporate = Cashbook::where('category_id', '=', 1)->get();
        $client = Cashbook::where('category_id', '=', 1)->get();

        $corporateNGN = Cashbook::where(
            [
                ['category_id', '=', 1], 
                ['currency_id', '=', 1],
                ['group_id', '=', 1]
            ]
        )->sum('amount') - Cashbook::where(
            [
                ['category_id', '=', 1], 
                ['currency_id', '=', 1],
                ['group_id', '=', 2]
            ]
        )->sum('amount');
        $corporateUSD = Cashbook::where(
            [
                ['category_id', '=', 1], 
                ['currency_id', '=', 2],
                ['group_id', '=', 1]
            ]
        )->sum('amount') - Cashbook::where(
            [
                ['category_id', '=', 1], 
                ['currency_id', '=', 2],
                ['group_id', '=', 2]
            ]
        )->sum('amount');
        $clientNGN = Cashbook::where(
            [
                ['category_id', '=', 2], 
                ['currency_id', '=', 1],
                ['group_id', '=', 1]
            ]
        )->sum('amount') - Cashbook::where(
            [
                ['category_id', '=', 2], 
                ['currency_id', '=', 1],
                ['group_id', '=', 2]
            ]
        )->sum('amount');
        $clientUSD = Cashbook::where(
            [
                ['category_id', '=', 2], 
                ['currency_id', '=', 2],
                ['group_id', '=', 1]
            ]
        )->sum('amount') - Cashbook::where(
            [
                ['category_id', '=', 2], 
                ['currency_id', '=', 2],
                ['group_id', '=', 2]
            ]
        )->sum('amount');
        // lastmonth only
        $lastCorporateNGN = Cashbook::whereMonth(
            'date', 
            '=', 
            $lastMonth 
        )->where(
            [
                ['category_id', '=', 1], 
                ['currency_id', '=', 1],
                ['group_id', '=', 1]
            ]
        )->sum('amount') - Cashbook::whereMonth(
            'date', 
            '=', 
            $lastMonth 
        )->where(
            [
                ['category_id', '=', 1], 
                ['currency_id', '=', 1],
                ['group_id', '=', 2]
            ]
        )->sum('amount');
        $lastCorporateUSD = Cashbook::whereMonth(
            'date', 
            '=', 
            $lastMonth 
        )->where(
            [
                ['category_id', '=', 1], 
                ['currency_id', '=', 2],
                ['group_id', '=', 1]
            ]
        )->sum('amount') - Cashbook::whereMonth(
            'date', 
            '>=', 
            $lastMonth 
        )->where(
            [
                ['category_id', '=', 1], 
                ['currency_id', '=', 2],
                ['group_id', '=', 2]
            ]
        )->sum('amount');
        $lastClientNGN = Cashbook::whereMonth(
            'date', 
            '=', 
            $lastMonth 
        )->where(
            [
                ['category_id', '=', 2], 
                ['currency_id', '=', 1],
                ['group_id', '=', 1]
            ]
        )->sum('amount') - Cashbook::whereMonth(
            'date', 
            '>=', 
            $lastMonth 
        )->where(
            [
                ['category_id', '=', 2], 
                ['currency_id', '=', 1],
                ['group_id', '=', 2]
            ]
        )->sum('amount');
        $lastClientUSD = Cashbook::whereMonth(
            'date', 
            '=', 
            $lastMonth 
        )->where(
            [
                ['category_id', '=', 2], 
                ['currency_id', '=', 2],
                ['group_id', '=', 1]
            ]
        )->sum('amount') - Cashbook::whereMonth(
            'date', 
            '=', 
            $lastMonth 
        )->where(
            [
                ['category_id', '=', 2], 
                ['currency_id', '=', 2],
                ['group_id', '=', 2]
            ]
        )->sum('amount');
        
        $lastMonthCorp = Cashbook::whereMonth(
            'date', 
            '=', 
            $lastMonth
        )->where([['category_id', '=', 1]])->get();

        $lastMonthCli = Cashbook::whereMonth(
            'date', 
            '=', 
            $lastMonth 
        )->where('category_id', '=', 2)
        ->get();

        return view(
            'finance.cashbook.index', 
            compact(
                'cashbooks',
                'corporate',
                'debits',
                'credits',
                'client',
                'banks',
                'corporateUSD',
                'corporateNGN',
                'clientNGN',
                'clientUSD',
                'lastClientUSD',
                'lastClientNGN',
                'lastCorporateUSD',
                'lastCorporateNGN',
                'lastMonthCorp',
                'lastMonthCli'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($param = '')
    {
        if ($param == '') {
            abort(404);
        }
        $clients = Client::all();
        $banks = Bank::all();
        $currencies = Currency::all();
        $client  = null;
        $cashbook  = null;
        $labels  = ($param == 'debit') ? 
            Cashbook_label::where('group_id', '1')->get() : 
            Cashbook_label::where('group_id', '2')->get();
        $view = ($param == 'debit') ? 
        'finance.cashbook.debit' : 'finance.cashbook.credit';
        return view(
            $view, 
            compact( 
                'clients', 
                'cashbook', 
                'banks', 
                'currencies', 
                'labels', 
                'client'
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
                'client' => 'nullable',
                'bank' => 'required',
                'currency' => 'required',
                'category' => 'required',
                'group' => 'required',
                'amount' => 'required',
                'label' => 'required',
                'description' => 'required'
            ]
        );
        $this->_transact($request);
        $this->_updateBank($request);
        
        return redirect()
            ->route('cashbook.index')
            ->with('status', toastReturnUpdate());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cashbook  $cashbook
     * @return \Illuminate\Http\Response
     */
    public function show(Cashbook $cashbook)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cashbook  $cashbook
     * @return \Illuminate\Http\Response
     */
    public function edit(Cashbook $cashbook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cashbook  $cashbook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cashbook $cashbook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cashbook  $cashbook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cashbook $cashbook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */    
    private function _transact($request)
    {
        $cashbook = new Cashbook;
        $cashbook->client_id = $request->client;
        $cashbook->bank_id = $request->bank;
        $cashbook->currency_id = $request->currency;
        $cashbook->category_id = $request->category;
        $cashbook->cashbook_label_id = $request->label;
        $cashbook->group_id = $request->group;
        $cashbook->description = $request->description;
        $cashbook->amount = $request->amount;
        $cashbook->date = date('Y-m-d');
        $cashbook->save();
    }

    private function _updateBank($request)
    {
        $bank = Bank::first($request->bank_id);
        //debit = 1, credit = 2.
        $bank->balance = (intval($request->group) == 1) ? 
            $bank->balance + $request->amount : 
            $bank->balance - $request->amount;
        $bank->save();
    }
}
