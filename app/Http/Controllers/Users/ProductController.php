<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductReview;
use Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product_detail = Product::with('product_reviews')->where('id', $id)->first();  
        if(!empty($product_detail)){
            if(!empty($product_detail->product_reviews)){
                foreach($product_detail->product_reviews as $reviews) {
                    $user_detail = User::where('id',$reviews->user_id)->first();
                    if(!empty($user_detail)){
                        $reviews->first_name = $user_detail->first_name;
                        $reviews->last_name = $user_detail->last_name;
                        $reviews->profile_image = $user_detail->profile_image;
                    }
                }
            }
            // dd($product_detail);
            return view('product_detail',compact(['product_detail']));
        }else{
            return back()->with('error','Product not found !');
        }
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
