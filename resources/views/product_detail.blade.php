@extends('layouts.home.app')
@section('content')
<style>*{
    margin: 0;
    padding: 0;
}
.rate {
    float: left;
    height: 46px;
    padding: 0 10px;
}
.rate:not(:checked) > input {
    position:absolute;
    top:-9999px;
}
.rate:not(:checked) > label {
    float:right;
    width:1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:30px;
    color:#ccc;
}
.rate:not(:checked) > label:before {
    content: '★ ';
}
.rate > input:checked ~ label {
    color: #ffc700;    
}
.rate:not(:checked) > label:hover,
.rate:not(:checked) > label:hover ~ label {
    color: #deb217;  
}
.rate > input:checked + label:hover,
.rate > input:checked + label:hover ~ label,
.rate > input:checked ~ label:hover,
.rate > input:checked ~ label:hover ~ label,
.rate > label:hover ~ input:checked ~ label {
    color: #c59b08;
}

/* Modified from: https://github.com/mukulkant/Star-rating-using-pure-css */</style>
<main>
  <div class="container mt-5">
    <div class="row">
        <!-- product detail  -->
        <div class="col-md-8 col-sm-12 mb-3">
            <div class="container mb-3">
                <div class="mySlides">
                    <img class="my-slider-img" src="{{asset($product_detail->image)}}">
                </div>
                <img class="my-slider-img" src="{{asset($product_detail->image)}}" style="width:100%" alt="No Image found..!">
            </div>
            <!--Image-->
            <div class="procuctDescription">
                <h3 class="mb-22">{{$product_detail->title}}</h3>
                <h2>Description</h2>
                <hr>
                <p>{{$product_detail->description}}</p>
            </div>
            <div class="sellerdetails">
                <h2>Reviews & Rating</h2>
                @foreach($product_detail->product_reviews as $review)
                    <div class="myrow">
                        <div class="mycol1 mb-3">
                            <div class="d-profile-img">
                                <img src="{{asset($review->profile_image)}}" alt="">
                            </div>
                            <div class="d-details">
                                <h3 style="margin: 0;">{{$review->first_name}} {{$review->last_name}}</h3>
                                <span class="fa fa-star checked"></span>
                                <span>{{$review->rating}}</span>
                                <p style="margin: 0;">{{$review->review}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <h3>Add Review</h3>
            <form action="{{ route ('user.reviews.update',$product_detail->id)}}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <label for="name"  style="color:#C59D5F">Rating :</label><br>
                <div class="rate">
                    <input type="radio" id="star5" name="rating" value="5" />
                    <label for="star5" title="5 stars">5 stars</label>
                    <input type="radio" id="star4" name="rating" value="4" />
                    <label for="star4" title="4 stars">4 stars</label>
                    <input type="radio" id="star3" name="rating" value="3" />
                    <label for="star3" title="3 stars">3 stars</label>
                    <input type="radio" id="star2" name="rating" value="2" />
                    <label for="star2" title="2 stars">2 stars</label>
                    <input type="radio" id="star1" name="rating" value="1" />
                    <label for="star1" title="1 star">1 star</label>
                </div> <br><br>
                <label for="name" style="color:#C59D5F">Your Review :</label>
                <textarea id="" cols="30" rows="4" class="form-control" name="review" required></textarea><br>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary3">Submit</button>
                </div>
            </form>        
        </div>
      </div>
  </div>  
</main

@endsection