<!--Sidebar Content-->
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Dashbord</div>
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <a class="nav-link" href="{{ route ('admin.users.index')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                        Users
                    </a>
                    <a class="nav-link" href="{{ route ('admin.products.index')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-list-alt"></i></div>
                        Products
                    </a>
                    <a class="nav-link" href="{{ route ('admin.reviews.index')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-comment"></i></div>
                        Products Reviews
                    </a>

                    <!-- <a class="nav-link" type="button" data-toggle="tooltip" title="Logout" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logout">
                        <div class="sb-nav-link-icon"><i class="fa fa-sign-out"></i></div>
                        Logout
                    </a> -->
                </div>
            </div>
        </nav>
    </div>
</div>