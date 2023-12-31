<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Models
use App\Models\User;
use App\Models\Product;
use App\Models\ProductReview;
// use App\Models\JobsMedia;
// use App\Models\ContactUs;
// use App\Models\Booking;
// use App\Models\Job;

class MainController extends Controller
{
    public function dashboard(){
        $users = User::where('user_type','1')->get();
        $count_users = User::where('user_type','1')->count();
        $count_products = Product::count();
        $count_reviews = ProductReview::count();

        return view('admin.dashboard',compact([
            'users',
            'count_users',
            'count_products',
            'count_reviews'
        ]));
    }
}
