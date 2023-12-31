 <!--Main Nav Start-->
 <nav class="navbar navbar-expand-lg navbar-light bg-dark py-3">
    <div class="container">
       <a class="navbar-brand text-light" href="{{ url ('/')}}">FeedBack System</a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
       </button>
       <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <ul class="navbar-nav navbar-b">
             <li class="nav-item">
                <a class="nav-link" href="{{ route('welcome') }}">Home</a>
             </li>
             <li class="nav-item">
                <a class="nav-link" href="{{ route('user.dashboard') }}">My Account</a>
             </li>
             <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" >Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> @csrf </form>
             </li>
          </ul>
       </div>
    </div>
 </nav>
 <!--Main Nav End-->
 <!--Top Profile img-->
 <div class="container">
    <div class="sellerdetails">
       <div class="myrow">
          <div class="mycol1">
             <div class="d-profile-img">
                <img src="{{asset(Auth::user()->profile_image)}}" alt="">
             </div>
             <div class="p-details">
                <div class="d-flex align-items-center">
                   <h3 style="margin: 0;">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h3>
                </div>
                <p style="margin: 0;">User <span>•</span>
                   <span>{{Auth::user()->email}}</span>
                </p>
             </div>
          </div>
          <div class="mycol2 d-flex justify-content-end">
             <div>
               <a href="{{ route ('user.settings')}}">
                  <button class="btn btn-primary3">Edit Profile</button>
               </a>   
                <button class="btn btn-primary5" href="{{ route('logout') }}" onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                   <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout </button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> @csrf </form>
             </div>
          </div>
       </div>
    </div>
 </div>
 
 <!--Top Profile img-->
 
 
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
 