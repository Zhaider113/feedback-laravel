<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductReview;
use Auth;

class ProductReviewController extends Controller
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
        //
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
        // dd($request->all());
        $update = Product::where('id',$id)->first();
        if(!empty($update)){
            $rating = new ProductReview();
            $rating->user_id = Auth::id();
            $rating->product_id = $update->id;
            $rating->rating = $request->rating;
            $rating->review = $request->review;
            $rating->status = 'pending';
            $rating->save();
            if($rating){
                return back()->with('success','Review Done Successfully !');
            }
            else{
                return back()->with('error','There is some trouble !');
            }
        }
        else{
            return back()->with('error','Product not found !');
        }
        return $update;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
