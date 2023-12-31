<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\customer;
use App\Models\CustomerCows;
use App\Models\ScoringReport;

use Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $customer = customer::get();
            return $this->success([$customer->count() > 0 ? 'Customer Found' : 'No Customer Found', $customer]);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
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
                'trading_name' => 'required',
                'surn_name' => 'required',
                'country_code' => 'required',
                'phone' => 'required',
                'mobile' => 'required',
                'location' => 'required',
                'latitude' => 'required', 
                'longitude' => 'required', 
                'postcode' => 'required', 
                'email' => 'required', 
                'invoice_email' => 'required', 
            ]);
            if($validator->fails())
            {
                return $this->error("All Fields Required..!");
            }
            $customer = new customer;
            $customer->trading_name = $request->trading_name;
            $customer->intial_name = $request->intial_name;
            $customer->surn_name = $request->surn_name;
            $customer->phone = $request->phone;
            $customer->country_code = $request->country_code;
            $customer->mobile = $request->mobile;
            $customer->location = $request->location;
            $customer->latitude = $request->latitude;
            $customer->longitude = $request->longitude;
            $customer->postcode = $request->postcode;
            $customer->email = $request->email;
            $customer->invoice_email = $request->invoice_email;
            $customer->save();
            return $this->success(['Customer Created Success']);
        } catch (\Throwable $th) {
            return $this->error("Email already exists or something is wrong..!");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $customer = customer::where('id', $id)->first();
            $cows = ScoringReport::where('customer_id', $customer->id)->get();
            // $reports = [];
            // array_push($reports, $customer);
            // foreach ($cows as $key => $value) {
            //     $scoring = ScoringReport::with('cows')->where('cows_id', $value->id)->get();
            //     array_push($reports, $scoring);
            // }
            return $this->success([$customer->count() > 0 ? 'Customer Found' : 'No Customer Found', ["customer"=>$customer, "cows"=>$cows]]);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $customer = customer::find($id);
            return $this->success([$customer->count() > 0 ? 'Customer Found' : 'No Customer Found', $customer]);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $id)
    {
            $customer = customer::where('id', $id)->first();
        try {
            if(empty($customer))
            {
                return $this->error('Customer not found');
            }
            if($request->has('trading_name') && !empty($request->trading_name))
            {
                $customer->trading_name = $request->trading_name;
            }
            if($request->has('intial_name') && !empty($request->intial_name))
            {
                $customer->intial_name = $request->intial_name;
            }
            if($request->has('surn_name') && !empty($request->surn_name))
            {
                $customer->surn_name = $request->surn_name;
            }
            if($request->has('country_code') && !empty($request->country_code))
            {
                $customer->country_code = $request->country_code;
            }
            if($request->has('phone') && !empty($request->phone))
            {
                $customer->phone = $request->phone;
            }
            if($request->has('mobile') && !empty($request->mobile))
            {
                $customer->mobile = $request->mobile;
            }
            if($request->has('location') && !empty($request->location))
            {
                $customer->location = $request->location;
                $customer->latitude = $request->latitude;
                $customer->longitude = $request->longitude;
            }
            if($request->has('postcode') && !empty($request->postcode))
            {
                $customer->postcode = $request->postcode;
            }
            if($request->has('email') && !empty($request->email))
            {
                $customer->email = $request->email;
            }
            if($request->has('invoice_email') && !empty($request->invoice_email))
            {
                $customer->invoice_email = $request->invoice_email;
            }
            $customer->save();
            return $this->success(['Customer Updated', $customer]);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
