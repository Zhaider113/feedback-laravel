<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth' , 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //return view('home');
        if(Auth::check()){
            if(Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } 
            else if(Auth::user()->isUser()) {
                // return redirect()->route('user.dashboard');
                if(Auth::user()->email_verified_at == null)
                {
                    return redirect()->route('action');
                }else{
                    return redirect()->route('user.dashboard');
                } 
            } 
            else if(Auth::user()->isVendor()) {
                    return redirect()->route('action');
            } 
        }      
    }
}
