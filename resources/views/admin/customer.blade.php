@extends('layouts.admin.app')
@section('content')

<div class="mt-3">
    <div class="row">
        <div class="col-md-9 ">
            <h4>Customer List</h4>
            @if(session()->has('message'))
                <div class="alert alert-success text-center">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger text-center">
                    {{ session()->get('error') }}
                </div>
            @endif
        </div>
        <div class="col-md-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route ('admin.dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Customer List</li>
                </ol>
            </nav>
        </div>
    </div> 
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Customer Data</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>                        
                                    <th>Name</th>                                        
                                    <th>Email</th>                                      
                                    <th>Phone</th>  
                                    <th>Address</th> 
                                    <th>Action</th>  
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>                        
                                    <th>Name</th>                                        
                                    <th>Email</th>                                      
                                    <th>Phone</th>
                                    <th>Address</th>  
                                    <th>Action</th> 
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($customer as $key=>$customer)                            
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            
                                                {{ $customer->trading_name }}&nbsp {{$customer->intial_name}}&nbsp {{$customer->surn_name}}
                                            
                                        </td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td>{{ $customer->location }}</td>
                                        <td><a class="btn btn-primary" href="{{route('admin.customer.show', ['customer' => $customer->id])}}">View Report</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div> 
    
@endsection