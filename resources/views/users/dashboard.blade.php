@extends('layouts.users.app') 
@section('content')
<style>
@media only screen and (max-width: 600px) {
.w-75 {
    width: 91% !important;
}

  }
</style>
<div class="container">
   <div class="row my-5">
        @include('layouts.users.sidenav')
        <div class="col-md-9 col-sm-12 d-right">
            <h3>Welcome Back</h3>
            <p>Here's an overview of your account.</p>
           
        </div>
    </div>
</div> 

@endsection