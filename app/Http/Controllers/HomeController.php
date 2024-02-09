<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('dashboard');
    }

    public function ChangePassword()
    {
        return view('auth.change_password');

    }

    public function UpdatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|same:new_password'
        ]);

        $user = Auth::user();
        if (!Hash::check($request->password, $user->password)){
            $data = [
                'message' => 'Password doesn\'t match with the old one', 
                'type'=> 'error', 
                'titl' => 'Error'
            ];
            return redirect()->back()->with('status', $data);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();

        $data = [
            'message' => 'Your Password has been updated successfully', 
            'type'=> 'success', 
            'titl' => 'Success'
        ];
        return redirect()->back()->with('status', $data);
    }
}
