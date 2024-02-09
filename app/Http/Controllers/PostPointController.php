<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Jobs\BonusPoint;
use App\Jobs\DeficitPoint;

class PostPointController extends Controller
{

    public function __construct()
    {
        $this->middleware('partners');
        
    }
    public function findAction(Request $request)
    {
        if ($request->has('deficit')) {
            return $this->dispatch(new DeficitPoint($request));
        } else if ($request->has('bonusPoint')) {
            return $this->dispatch(new BonusPoint($request));
        } else {
            return 'No action found';
        }
    }
}
