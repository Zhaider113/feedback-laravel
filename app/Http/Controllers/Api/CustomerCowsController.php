<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerCows;
use App\Models\ScoringReport;
use Illuminate\Http\Request;
use Validator;

class CustomerCowsController extends Controller
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
        try {
            $validator = Validator::make($request->all(),[
                'customer_id' => 'required',
                'cow_id' => 'required',
                'gender' => 'required',
            ]);
            if($validator->fails())
            {
                return $this->error("Select Customer..!");
            }
            $cow = new CustomerCows;
            $cow->customer_id  = $request->customer_id;
            $cow->cow_id  = $request->cow_id;
            $cow->gender  = $request->gender;
            $cow->save();
            if ($cow) 
            {
                return $this->success(['Cow Added successfully....!']);
            }
            else
            {
                return $this->error(['Adding failed !']);
            }

        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $cows = CustomerCows::find($id);
            $scoring = ScoringReport::where('cows_id', $id)->get();
            // dd($scoring);
            return $this->success([$cows->count() > 0 ? 'Cows Found' : 'No Cows Found', ["cows"=>$cows, "scoring"=>$scoring]]);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
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

    public function getCustomerCows(string $id){
        try {
            $cows = CustomerCows::where('customer_id',$id)->get();
            // dd($scoring);
            return $this->success([$cows->count() > 0 ? 'Cows Found' : 'No Cows Found', ["cows"=>$cows]]);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }
}
