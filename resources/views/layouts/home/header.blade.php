        <!--Main Nav Start-->
        <nav class="navbar navbar-expand-lg navbar-light bg-dark py-2">
        <div class="container">
        <a class="navbar-brand text-light" href="{{ url ('/')}}">FeedBack System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav navbar-b">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">Home</a>
            </li>
            <!--<li class="nav-item">-->
            <!--    <a class="nav-link" href="{{ route('register') }}">Membership</a>-->
            <!--</li>-->
            <!-- <li class="nav-item">
                <a class="nav-link" href="{{url ('About_Us')}}">About Us</a>
            </li> 
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="modal" data-bs-target="#message-submite" href="#" style = "color: white">Contact Us</a>
            </li>  -->
            @guest
            <li class="nav-item">
                <a class="nav-link" href="{{route ('login')}}">Sign In</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route ('register')}}">Register</a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link" href="{{route ('register')}}">Dashboard</a>
            </li>
            @endguest
            </ul>
        </div>
    </div>
</nav>
    <!--Main Nav End-->
    
<!-- Modal -->
<div class="modal fade" id="message-submite" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background:#C59D5F">
        <h5 class="modal-title" id="staticBackdropLabel" style="color:white">Contact Us</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('contact_message')}}" method = "POST">
        {{ csrf_field() }}
        {{ method_field('POST') }}
            <div class="modal-body" style="background:#C59D5F">
                <label for="name" style="color:white">Full Name :</label>
                <input type="text" class="form-control" name="name" value="" style="height: 40px;" required>

                <label for="email" style="color:white">Email :</label>
                <input type="text" class="form-control" name="email" value="" style="height: 40px;" required>

                <label for="name" style="color:white">Your Message :</label>
                <textarea id="" cols="30" rows="4" class="form-control" name="message" required></textarea>
            </div>
            <div class="modal-footer" style="background:#C59D5F">
                <button type="button" class="btn btn-primary5" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary5">Submit</button>
            </div>
        </form>
    </div>
  </div>
</div>
    
    