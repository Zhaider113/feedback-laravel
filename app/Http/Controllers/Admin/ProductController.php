<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::get();
        return view('admin.products.index',compact(['products']));
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
        $store = new Product();
        $store->title = $request->title;
        $store->description = $request->description;
        if($request->has('image') && $request->image != "")
        {
            if($request->image->getClientOriginalExtension() == 'png' 
            ||$request->image->getClientOriginalExtension() == 'PNG' 
            || $request->image->getClientOriginalExtension() == 'jpg' 
            || $request->image->getClientOriginalExtension() == 'JPG' 
            || $request->image->getClientOriginalExtension() == 'jpeg' 
            || $request->image->getClientOriginalExtension() == 'JPEG')
            {
                $newfilename = md5(mt_rand()) .'.'. $request->image->getClientOriginalExtension();
                $request->file('image')->move(public_path("/product_images"), $newfilename);
                $new_path1 = 'product_images/'.$newfilename;
                $store->image = $new_path1;
            }
            else{
                return back()->with('error','Choose a Valid Image !');
            }                       
        }    
        $store->save();
        if($store){
            return back()->with('success','Product Added Successfully !');
        }
        else{
            return back()->with('error','there are some errors !');
        }
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
        $update = Product::where('id',$id)->first();
        if(!empty($update)){
            if($request->has('title') && $request->title !="" || $request->title !=null){
                $update->title = $request->title;
            }
            if($request->has('image') && $request->image != "" ||$request->image !=null)
            {
                if($request->image->getClientOriginalExtension() == 'png' 
                ||$request->image->getClientOriginalExtension() == 'PNG' 
                || $request->image->getClientOriginalExtension() == 'jpg' 
                || $request->image->getClientOriginalExtension() == 'JPG' 
                || $request->image->getClientOriginalExtension() == 'jpeg' 
                || $request->image->getClientOriginalExtension() == 'JPEG')
                {
                    $newfilename = md5(mt_rand()) .'.'. $request->image->getClientOriginalExtension();
                    $request->file('product_image')->move(public_path("/product_images"), $newfilename);
                    $new_path1 = 'product_images/'.$newfilename;
                    $update->image = $new_path1;
                }
                else{
                    return back()->with('error','Choose a Valid Image !');
                }                       
            }    
            $update->save();
            if($update){
                return back()->with('success','Product Details Updated Successfully !');
            }
        }
        else{
            return back()->with('error','this record is not found !');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destroy = Product::where('id',$id)->first();
        if(!empty($destroy)){       
            $destroy->delete();
            if($destroy){
                return back()->with('success','Product Deleted Successfully !');
            }
        }
        else{
            return back()->with('error','this record is not found !');
        }
    }
}
