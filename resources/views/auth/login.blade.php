<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{asset('theme/home/style/style.css')}}">
        <link rel="stylesheet" href="{{asset('theme/home/bootstrap/css/bootstrap.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Sign In</title>
    </head>
<body>

    <!--Signup Form Start-->
    <main>
        <section>
            <div class="row m-0">
                <div class="col-md-4 col-sm-12 signin-img p-0">
                    <img class="w-100" src="{{asset('theme/home/assets/imgs/login6.jpg')}}" alt="">
                </div>
                <div class="col-md-8 col-sm-12">
                    <div class="Signup-form">
                        <a style="width:130px;" class="navbar-brand text-dark"  href="{{ url ('/')}}">FeedBack System</a>
                        <br>
                        <div class="d-flex align-items-center justify-content-between"><h1>Sign In</h1> <span class="v-line"></span></div>
                        <p>Don't have an account? <a href="{{route ('register')}}">Sign up</a></p>
                        <form action="{{ route('login') }}" method="POST">
                        @csrf   
                            <div class="form-group">
                            <input type="email" name = "email" class="form-control form-control-user @error('email') is-invalid @enderror"
                                id="exampleInputEmail" value="{{ old('email') }}" aria-describedby="emailHelp"
                                placeholder="Enter Email Address..." required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" name = "password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                    id="exampleInputPassword" placeholder="Password" required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                            </div>
                            <button type="submit" class="btn btn-secondary mt-3">Sign In</button>
                             @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
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