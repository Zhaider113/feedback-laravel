@extends('layouts.admin.app')
@section('content')
<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
            <h3 class="mt-4">Dashboard</h3>
                <div class="card mb-4">
                
                    <div class="card-header">
                        <i class="fa fa-list-alt"></i>
                        Reviews Data
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" style="margin-right:-30px">
                            <thead>
                                <tr>
                                    <th>ID</th>                        
                                    <th>Review From</th>
                                    <th>Product</th>
                                    <th>Review</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>                        
                                    <th>Review From</th>
                                    <th>Product</th>
                                    <th>Review</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            @foreach($reviews as $review)   
                                <tr>
                                    <td>{{$review->id}}</td>
                                    <td>{{$review->users->first_name}} {{$review->users->last_name}}</td>
                                    <td>{{$review->products->title}}</td>
                                    <td>{{$review->review}}</td>
                                    <td>{{$review->rating}} <i class="fa-solid fa-star" style="color:#ebd84d"></i></td>
                                    <td>{{$review->status}}</td>
                                    <td>
                                        <div class="row pl-3">    
                                            <div class = "col-md-6 col-6">
                                                <button type="button" data-toggle="tooltip" title="Edit Review Status" class = "btn btn-sm btn-circle btn-outline-primary" style ="margin-left: 10px;border-radius:20px" data-bs-toggle="modal" data-bs-target="#editStatus-{{$review->id}}">
                                                    <i class="fa fa-edit" aria-hidden="true"></i></a>
                                                </button>
                                            </div>
                                            <div class = "col-md-6 col-6">
                                                <button type="button" data-toggle="tooltip" title="Delete Review" class="btn btn-sm btn-circle btn-outline-danger" style ="border-radius:20px" data-bs-toggle="modal" data-bs-target="#deleteReview-{{$review->id}}">
                                                    <i class="fa fa-trash" aria-hidden="true"></i></a>
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

@foreach($reviews as $review)  
<!-- Modal Edit Review Status-->
<div class="modal fade" id="editStatus-{{$review->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title" id="exampleModalLabel" style="color:white">Update Review Status</h5>
                <!--<button type="button" class="btn-close" class="text-light" data-bs-dismiss="modal" aria-label="Close"></button>-->
                <button type="button" class="text-light" data-bs-dismiss="modal" aria-label="Close" style="background: transparent;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body bg-dark" >
                <form action="{{ route ('admin.reviews.update',$review->id)}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                    <div class="form-outline mb-4">
                        <label class="form-label" style="color:white">Product</label>
                        <input type="text" name="" class="form-control" value="{{$review->products->title}}" readonly>
                    </div>
                    
                    <div class="form-outline mb-4">
                        <label class="form-label" style="color:white">From</label>
                        <input type="text" name="" class="form-control" value="{{$review->users->first_name}} {{$review->users->last_name}}" readonly>
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label" style="color:white">Review</label>
                        <textarea name="" id="" class="form-control" cols="57" rows="10" readonly>{{$review->review}}</textarea>
                    </div>
                    
                    <div class="form-outline mb-2">
                        <label class="form-label" style="color:white">Select Status</label>
                        <select name="status" id="status" class="form-select">
                            @if($review->status == "accepted")
                            <option value="accepted" selected>Accepted</option>
                            <option value="rejected">Rejected</option>
                            <option value="pending">Pending</option>
                            @elseif($review->status == "rejected")
                            <option value="accepted">Accepted</option>
                            <option value="rejected" selected>Rejected</option>
                            <option value="pending">Pending</option>
                            @else
                            <option value="accepted">Accepted</option>
                            <option value="rejected">Rejected</option>
                            <option value="pending" selected>Pending</option>
                            @endif
                        </select>
                    </div>
                    <br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
     </div>
</div>

<!-- Modal Delete Reviews -->
<div class="modal fade" id="deleteReview-{{$review->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title" id="exampleModalLabel" style=" font-family: Comic Sans MS;color: white;font-size:15px">Do You Really Want to Delete?</h5>
                <button type="button" class="text-light" data-bs-dismiss="modal" aria-label="Close" style="background: transparent;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-footer bg-dark">
                <form action="{{ route ('admin.reviews.destroy',$review->id)}}" method = "POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete Reviews</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection