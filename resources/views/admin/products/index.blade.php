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
                        Products Data
                       <!-- Button trigger modal -->
                        <div class="d-flex justify-content-end">
                            <button type="button" data-toggle="tooltip" title="Add New Product" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNew" style="margin-top: -25px; padding: 6px 30px">
                                <i class="fa fa-plus" aria-hidden="true"></i> New</a>
                            </button>
                        </div> 
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" style="margin-right:-30px">
                            <thead>
                                <tr>
                                    <th>ID</th>                        
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>                        
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{$product->id}}</td>
                                    <td>{{$product->title}}</td>
                                    <td>{{$product->description}}</td>
                                    <td>
                                    <div style = "margin-left: 3px; width: 40px; height: 40px; background: url({{ asset($product->image) }}); background-size: contain; background-repeat: no-repeat;"></div>
                                    </td>
                                    <td>
                                    <div class="row pl-3">    
                                            <!-- <div class = "col-md-3 col-6">
                                                <button type="button" data-toggle="tooltip" title="Edit Product" class = "btn btn-sm btn-circle btn-outline-primary" style ="margin-left: 10px;border-radius:20px" data-bs-toggle="modal" data-bs-target="#editProduct-{{$product->id}}">
                                                    <i class="fa fa-edit" aria-hidden="true"></i></a>
                                                </button>
                                            </div> -->
                                            <div class = "col-md-3 col-6">
                                                <button type="button" data-toggle="tooltip" title="Delete Product" class="btn btn-sm btn-circle btn-outline-danger" style ="border-radius:20px" data-bs-toggle="modal" data-bs-target="#deleteproduct-{{$product->id}}">
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

<!-- Modal Add New product-->
<div class="modal fade" id="addNew" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title" id="exampleModalLabel" style="color:white">Add New product</h5>
                <button type="button" class="text-light" data-bs-dismiss="modal" aria-label="Close" style="background: transparent;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body bg-dark" >
                <form class="p-3" action="{{route ('admin.products.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="form-outline mb-4">
                        <label class="form-label" style="color:white">Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <label class="form-label" style="color:white">Description</label>
                    <div class="form-outline mb-4">
                        <textarea name="description" id="description" cols="52" rows="10"></textarea>
                    </div>
                    <div class="form-outline mb-2">
                        <label class="form-label" style="color:white">Image</label>
                        <input type="file" name="image" class="form-control" >
                    </div>
                    <br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@foreach($products as $product)
                            
    <!-- Modal Edit product-->
    <div class="modal fade" id="editproduct-{{$product->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:white">Update product</h5>
                    <button type="button" class="text-light" data-bs-dismiss="modal" aria-label="Close" style="background: transparent;">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body bg-dark" >
                    <form action="{{ route ('admin.products.update',$product->id)}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                        <div class="form-outline mb-4">
                            <label class="form-label" style="color:white">Product Name</label>
                            <input type="text" name="title" class="form-control" value="{{$product->title}}">
                        </div>
                        
                        <div class="form-outline mb-2">
                            <label class="form-label" style="color:white">Old Product Image</label>
                            <div style = "margin-left: 3px; width: 70px; height: 70px; background: url({{ asset($product->image) }}); background-size: contain; background-repeat: no-repeat;"></div>
                        </div>
                        
                        <div class="form-outline mb-2">
                            <label class="form-label" style="color:white">Select New Image</label>
                            <input type="file" name="product_image" class="form-control">
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

    <!-- Modal Delete Provider -->
    <div class="modal fade" id="deleteproduct-{{$product->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title" id="exampleModalLabel" style=" font-family: Comic Sans MS;color: white;font-size:15px">Do You Really Want to Delete?</h5>
                    <button type="button" class="text-light" data-bs-dismiss="modal" aria-label="Close" style="background: transparent;">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-footer bg-dark">
                    <form action="{{ route ('admin.products.destroy',$product->id)}}" method = "POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach   
@endsection