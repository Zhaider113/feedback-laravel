@extends('layouts.admin.app')
@section('content')       
<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h3 class="mt-4">Dashboard</h3>
                <!-- <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">User Details</li>
                </ol> -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-users me-1"></i>
                        Recent Register Users
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>email</th>
                                    <th>Phone</th>
                                    <th>Profile Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</yh>
                                    <th>Full Name</th>
                                    <th>email</th>
                                    <th>Phone</th>
                                    <th>Profile Image</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->first_name}} {{$user->last_name}}</td>
                                    <th>{{$user->email}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>
                                        <div style = "margin-left: 15px; width: 30px; height: 30px; background: url({{ asset($user->profile_image) }}); background-size: contain; background-repeat: no-repeat;"></div>
                                    </td>
                                    <td>
                                        <div class="row">    
                                            <div class = "col-md-6 col-6">
                                                <button type="button" data-toggle="tooltip" title="View Customer Details" class = "btn btn-sm btn-circle btn-outline-primary" style ="border-radius:20px" data-bs-toggle="modal" data-bs-target="#viewUser-{{$user->id}}">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                            <div class = "col-md-2 col-6">
                                                <button type="button" data-toggle="tooltip" title="Delete Customer" class="btn btn-sm btn-circle btn-outline-danger" style ="border-radius:20px" data-bs-toggle="modal" data-bs-target="#deleteUser-{{$user->id}}">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </div>     
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>   
    </div>
</div>

@foreach($users as $user)
<!-- Modal viewProvider-->
<div class="modal fade" id="viewUser-{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width:110%">
            <div class="modal-header bg-dark">
                <h5 class="modal-title" id="exampleModalLabel" style="color:white;">User Details</h5>
                <button type="button" class="text-light" data-bs-dismiss="modal" aria-label="Close" style="background: transparent;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body bg-dark" >
                <table class="table" style="color:white" id="printTable">
                    <tbody>
                        <tr>
                            <th scope="row">ID</th>
                            <td>{{$user->id}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Full Name</th>
                            <td>{{$user->first_name}} {{$user->last_name}}</td>
                        </tr>
                        <tr>
                            <th scope="row">User Name</th>
                            <td>{{$user->username}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <td>{{$user->email}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Phone</th>
                            <td>{{$user->phone}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Profile Image</th>
                            <td>
                                <div style = "margin-left: 15px; width: 30px; height: 30px; background: url({{ asset($user->profile_image) }}); background-size: contain; background-repeat: no-repeat;"></div>
                            </td>
                        </tr>
                    </tbody>  
                </table>
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
     </div>
</div>

<!-- Modal Delete Provider -->
<div class="modal fade" id="deleteUser-{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title" id="exampleModalLabel" style=" font-family: Comic Sans MS;color: white;font-size:15px">Do You Really Want to Delete?</h5>
                <button type="button" class="text-light" data-bs-dismiss="modal" aria-label="Close" style="background: transparent;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-footer bg-dark">
                <form action="{{ route ('admin.users.destroy',$user->id)}}" method = "POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete User</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection       