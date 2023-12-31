<!-- Navbar Content -->
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <h4 style="color:white;margin-left: 43px">Feedback System</h4>
    <!-- <img src="{{asset('assets/img/white_logo.png')}}" alt="IMG" style="width:12%; height:158%; margin-left:29px; padding-left: 0px;"> -->
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars" style="margin-left: 48px"></i></button>
    
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <!-- <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
        </div> -->
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="{{asset(Auth::user()->profile_image)}}" style="width:40px; height:40px;border-radius:20px;margin-right:10px">{{ Auth::user()->first_name }}</a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <!-- <li><a class="dropdown-item" href="#!">Settings</a></li>-->
                <!--<li><a class="dropdown-item" href="#!">{{ Auth::user()->first_name }}</a></li>-->
                <!--<li><hr class="dropdown-divider" /></li>-->
                
                <li>
                    <button type="button" data-toggle="tooltip" title="Logout" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logout">Logout
                        <i class="fa fa-sign-out" aria-hidden="true"></i></a>
                    </button>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<!-- Modal Logout -->
<div class="modal fade" id="logout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title" id="exampleModalLabel" style=" font-family: Comic Sans MS;color: white;font-size:15px">Do You Really Want to Logout ?</h5>
                <button type="button" class="text-light" data-bs-dismiss="modal" aria-label="Close" style="background: transparent;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-footer bg-dark">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout </button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> @csrf </form>
            </div>
        </div>
    </div>
</div>