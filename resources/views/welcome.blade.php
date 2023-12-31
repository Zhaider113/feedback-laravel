@extends('layouts.home.app')
@section('content')
<main>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.17.6/dist/css/uikit.min.css" />
<script src="https://cdn.jsdelivr.net/npm/uikit@3.17.6/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.17.6/dist/js/uikit-icons.min.js"></script>

<style>
    
    .uk-slider-items li{
    padding: 0px 8px;
}

.uk-light .uk-slidenav{
    color: rgba(255,255,255,.7);
    background: gray;
    border-radius: 7px;
}
.uk-position-center-left {
    right: 60px !important;
    top: 33px !important;
    left: unset !important;
}

.uk-position-center-right {
    right: 10px !important;
    top: 33px !important;
}

@media only screen and (max-width: 600px) {
 .mobNavlink.home{
        color: #c59d5f;
    }
}


</style>

    
     <!-- Featured jobs test  -->
    <div class="container mb-5 Featured">
        <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider>
            <div class="row mb-3 mt-5">
                <div class="col-md-6 col-sm-6">
                    <h2 style="color: black;">Products List</h2>
                </div>
                <div class="col-md-6 col-sm-6 d-flex justify-content-end">
                    
                </div>
            </div>
            <ul class="uk-slider-items uk-child-width-1-1 uk-child-width-1-3@s uk-child-width-1-4@m">
                @foreach($products as $product)
                    <li>
                        @auth
                            <a href="{{ route ('product_details',$product->id)}}">
                        @else
                            <a href="{{ route ('login')}}">
                        @endauth
                        <div class="card" >
                            <img style="width: 100%;height: 253px; object-fit: cover;" class="card-img-top" src="{{asset($product->image)}}" alt="Card image cap">
                            <div class="card-body">
                                <h5 style="color: black; margin-top: 0;" class="card-title">{{$product->title}}</h5>
                                
                            </div>
                            <hr style="margin: 0;height: 1px;background: black;">
                            <div class="card-body d-flex justify-content-between align-items-center" style="padding: 5px 18px;">
                                <div class="icons">
                            </div>
                        </div>
                    <!-- </div> -->
                        </a>
                    </li>
                @endforeach
            </ul>
      
          <a class="uk-position-center-left " href uk-slidenav-previous uk-slider-item="previous"></a>
          <a class="uk-position-center-right " href uk-slidenav-next uk-slider-item="next"></a>
      
        </div>
    </div>
      
</main>
@endsection