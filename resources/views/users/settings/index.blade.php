@extends('layouts.users.app')
@section('content')
 <main>
      <!--UserDashbord-->
      <div class="container">
        <div class="row my-5">
          <!--DashbordLeft-->
          @include('layouts.users.sidenav')
          <!--DashbordLeft-->
          <!--DashbordRight-->
          <div class="col-md-9 col-sm-12 d-right settingForm">
            <form action="{{ route ('user.update_information')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
              <h4 class="mt-3">Basic Details</h4>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="username">First Name</label>
                    <input name="first_name" type="text" class="form-control" id="username" value="{{Auth::user()->first_name}}">
                  </div>
                  <div class="form-group mb-3">
                    <label for="firstName">Last Name</label>
                    <input name="last_name" type="text" class="form-control" id="firstName" value="{{Auth::user()->last_name}}">
                  </div>
                  <div class="form-group mb-3">
                    <label for="Language">Username</label>
                    <input name ="username" type="text" class="form-control" id="Language" value="{{Auth::user()->username}}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="Email">Email</label>
                    <input name="email" type="email" class="form-control" id="Email" value="{{Auth::user()->email}}">
                  </div>
                  <div class="form-group mb-3">
                    <label for="lastName">Phone</label>
                    <input name="phone" type="text" class="form-control" id="lastName" value="{{Auth::user()->phone}}">
                  </div>
                  
                  <div class="form-group mb-3">
                    <label for="lastName">Profile Image</label>
                    <input name="profile_image" type="file" class="form-control" id="profileImage">
                  </div>
                </div>
              </div>
              <h4 class="mt-3">Password</h4>
              <p>Only complete these fields if you wish to change the existing password.</p>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="password">Old Password</label>
                    <input name="old_password" type="password" class="form-control" id="password" placeholder="Enter Password">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="passwordre">New Password</label>
                    <input name="new_password" type="password" class="form-control" id="passwordre" placeholder="Enter New Password">
                  </div>
                </div>
                <!-- <div class="col-md-6">
                  <div class="form-group mb-3">
                    <label for="passwordre">Re-type New Password</label>
                    <input type="password" class="form-control" id="passwordre" placeholder="Enter Password Again">
                  </div>
                </div> -->
              </div>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
            <hr>
            <h4 class="mt-3">Delete Account</h4>
            <div class="delAccount">
            <p>We're really sad to see you go, but we understand that situations change. Click to 'delete account'
              button below to confirm you wish to delete your account. Once processed, you must logout.</p>
              <a href="{{ route ('user.delete_auth_account')}}">
              <button onclick = "return confirm('Do You Really Want to Delete Your Account ?')" class="btn btn-primary5">Delete Account</button>
              </a>
              
            </div>
          </div>
          <!--DashbordRight-->
        </div>
      </div>
      <!--UserDashbord-->

  </main>


@endsection