<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{asset('theme/home/style/style.css')}}">
        <link rel="stylesheet" href="{{asset('theme/home/bootstrap/css/bootstrap.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Sign Up</title>
    </head>
<body>

    <!--Signup Form Start-->
    <main>
        <section>
            <div class="row m-0">
                <div class="col-md-4 col-sm-12 signup-img p-0">
                    <img class="w-100" src="{{asset('theme/home/assets/imgs/login6.jpg')}}" alt="">
                </div>
                <div class="col-md-8 col-sm-12">
                    <div class="Signup-form">
                        <a style="width:130px;" class="navbar-brand text-dark" href="{{url ('/') }}">FeedBack system</a>
                        <br>
                        <div class="d-flex align-items-center justify-content-between"><h1>Sign Up</h1> <span class="v-line"></span></div>
                        <p>Already a member? <a href="{{ route ('login')}}">Sign In</a></p>
                        <form action="{{ route('register') }}" method="POST">
                        @csrf
                            <div class="form-group">
                                <input id="name" type="text" class="form-control @error('first-name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}"  autocomplete="first_name" placeholder="First Name" autofocus>
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}"  autocomplete="last_name" placeholder="Last Name" autofocus>
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" placeholder="Enter Email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Choose A Unique Username" value="{{ old('username') }}">
                                <!-- <div class="my-tooltip"></div><div class="info"><i class="fa-regular fa-circle-question"></i></div>
                                <span class="tooltip-cont"><div class="tooltip-con">Choose a unique Username</div></span> -->
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                
                            </div>

                            <div class="form-group">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password" placeholder="Confirm Password">
                            </div>
                            <div style="display:none">
                                <p>Account Type</p>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="user_type" id="exampleRadios1" value="1" checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                    Guest
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="user_type" id="exampleRadios2" value="2">
                                    <label class="form-check-label" for="exampleRadios2">
                                    Provider
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-check  mt-3">
                                <input class="form-check-input" name="term_condition" type="checkbox" value="yes" id="flexCheckDefault" Required>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Accept <a href="{{ url('/').'/terms_and_conditions.pdf' }}" target="_blank">Terms & conditions</a>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-secondary mt-3">Create Account</button>
                        </form>
                    </div>

                </div>
            </div>
        </section>
    </main>
    <!--Signup Form End-->
    

    <script src="{{asset('theme/home/bootstrap/js/bootstrap.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>