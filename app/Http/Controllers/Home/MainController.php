<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// use App\Models\UserWebsiteReviews;
use App\Models\User;
// use App\Models\Categories;
use App\Models\Product;

class MainController extends Controller
{
    public function welcome() {
        
        $products = Product::orderby('created_at','desc')->get();
     
        if(\Auth::check())
        {
            $user_id = \Auth::user()->id;
        }else{
            $user_id = "";
        }
        return view('welcome',compact(['products', 'user_id']));
    }
}
