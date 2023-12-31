@extends('layouts.home.app')
@section('content')
<main>
    <div class="container mt-5" style = "height: 600px;">
        <h2>Account Verification</h2>
        <hr>
        <h5>An Account Verification Email has been Sent to You. Please Verify You Email</h5>
        <br>
        <br>
        <a href = "{{ route('logged_out') }}" class="btn btn-primary">Logout</a>
    </div>
</main>

      

@endsection