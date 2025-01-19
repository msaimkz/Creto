@extends('User.master')
@section('content')
@php
$img = $product->image->first()
@endphp
@if(Session::get('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    <div>
        {!! Session::get('success') !!}
    </div>
</div>
@endif


@if(Session::get('error'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    {{Session::get('error')}}
</div>
@endif
<div class="Product-Detail-container">
    <div class="product-detail-image">
        <div class="main-image">
            @if(!empty($img->image))
            <img src="{{asset('uploads/product/large/'.$img->image)}}" class="Image">
            @else
            <img src="{{asset('asset/img/default.avif')}}" class="Image">
            @endif
        </div>
        <div class="sub-image-container">
            @if(!empty($product->image))
            @foreach($product->image as $key => $productimages)
            <div><img src="{{asset('uploads/product/large/'.$productimages->image)}}" alt=""
                    class="sub-image {{( $key == 0) ? 'active' : '' }}"></div>
            @endforeach
            @endif
        </div>
    </div>
    <div class="product-detail-content">
        <h1 class="nav-nigth">{{$product->title}}</h1>
        <div class="Product-price">
            <h2 class="nav-nigth">${{$product->price}}</h2>
        </div>
        <p class="nigth-description">{!! $product->description !!}</p>
        <div class="Product-button">
            @if($product->qty != 0)
            <a href="javascript:void(0)" onclick="AddtoCart('{{$product->id}}')" class="cart-button gear-button">Add To
                cart </a>
            @else
            <a href="javascript:void(0)" class="cart-button gear-button">Out of Stock</a>
            @endif
            <a href="javascript:void(0)" class="wishlit-button gear-button"
                onclick="AddWishlist('{{$product->id}}')">Add to
                Wishlist</a>
        </div>
    </div>
</div>
<div class="Product-comment-container">
    <h1 class="nav-nigth">Shipping</h1>
    <div class="Product-comment">
        <div class="comment-content">
            <p class="nigth-shipping">{!! $product->shipping !!}</p>
        </div>
        <h1 class="nav-nigth">Reviews</h1>
        <div class="Product-comment">
            @if(!empty($ratings))
            @foreach($ratings as $rating)
            <div class="comment-content">
                <h2 class="nav-nigth">{{ $rating->name}}</h2>
                <span class="nav-nigth">{{ \Carbon\Carbon::parse($rating->created_at)->format('M d, Y')}}</span>
                <p class="nav-nigth">{{ $rating->message }}</p>
            </div>
            @endforeach
            @else
            <h1>Rating Not Found</h1>
            @endif

        </div>
    </div>
    <form action="" class="form" method="post" id="RatingForm" name="RatingForm">
        <h1 class="nav-nigth comment">Leave a Comment</h1>
        <div class="service-input comment-input">
            <div>
                <input type="text" placeholder="Name" class="dark-input-service form-control" id="name" name="name">
                <span></span>
            </div>
            <div>
                <input type="email" placeholder="Email" class="dark-input-service form-control" id="email" name="email">
                <span></span>
            </div>
        </div>
        <div>
            <textarea name="message" id="message" cols="20" rows="6" placeholder="message"
                class="dark-input-service form-control" name="message" id="message"></textarea>
            <span></span>
        </div>
        <button class="comment-button gear-button" type="submit"><span>Submit Commit</span></button>


    </form>
    <div class="fouth-section">
        <div class="fourt-head-section">
            <h1 class="nav-nigth Related-product">Related Products</h1>
        </div>
        <div class="fourth-card-container">
            @if(!empty($relatedProducts))
            @foreach($relatedProducts as $relatedProduct)
            @php
            $img = $relatedProduct->image->first()
            @endphp
            <div class="fourth-card">
                <div class="fourth-img-box card-dark-img">
                    @if(!empty($img->image))
                    <img src="{{asset('uploads/product/small/'.$img->image)}}" class="img-thumbnail" width="50">
                    </td>
                    @else
                    <img src="{{asset('asset/img/default.avif')}}" class="img-thumbnail" width="50"></td>
                    @endif
                </div>
                <div class="fourth-content-box card-dark">
                    <h2 class="sec4-nav-nigth">Rs: {{$relatedProduct->price}}</h2>
                    <p class="sec8-nav-nigth">{{$relatedProduct->title}}</p>
                    <a class="gear-button" href="{{route('Product',$relatedProduct->slug)}}"><span>View More</span></a>
                </div>
            </div>
            @endforeach
            @else
            <h1>Product Not Found</h1>
            @endif
        </div>
    </div>
    @endsection
    @section('js')
    <!-- javascript link  -->
    <script src="{{asset('asset/user/js/Product.js')}}"></script>

    <script type="text/javascript">
    function AddtoCart(id) {
        $.ajax({
            url: '{{route("Add-to-Cart")}}',
            type: 'post',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == true) {
                    window.location.href = "{{route('Cart')}}"
                } else {
                    alert(response.msg)
                }
            },
        });
    }

    function AddWishlist(id) {
        $.ajax({
            url: '{{route("Store-Wishlist")}}',
            type: 'post',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == true) {
                    window.location.href = "{{route('Product',$product->slug)}}"
                } else {
                    alert(response.msg)
                }
            },
        });
    }


    $('#RatingForm').submit(function(event) {
        event.preventDefault();
        $('button[type=submit]').prop('disabled', true)
        $.ajax({
            url: '{{ route("Store-Rating",$product->id) }}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response) {
                $('button[type=submit]').prop('disabled', false)
                if (response.isLogin == false) {
                    alert(response.msg)
                }
                if (response['status'] == true) {
                    window.location.href = "{{route('Product',$product->slug)}}";

                    $('#name').removeClass('is-invalid').siblings('span').removeClass(
                            'invalid-feedback')
                        .html('')
                    $('#email').removeClass('is-invalid').siblings('span').removeClass(
                            'invalid-feedback')
                        .html('')
                    $('#message').removeClass('is-invalid').siblings('span').removeClass(
                            'invalid-feedback')
                        .html('')

                } else {


                    var error = response['errors']
                    if (error['name']) {
                        $('#name').addClass('is-invalid').siblings('span').addClass(
                                'invalid-feedback')
                            .html(error['name'])
                    } else {
                        $('#name').removeClass('is-invalid').siblings('span').removeClass(
                            'invalid-feedback').html('')
                    }

                    if (error['email']) {
                        $('#email').addClass('is-invalid').siblings('span').addClass(
                                'invalid-feedback')
                            .html(error['email'])
                    } else {
                        $('#email').removeClass('is-invalid').siblings('span').removeClass(
                            'invalid-feedback').html('')
                    }
                    if (error['message']) {
                        $('#message').addClass('is-invalid').siblings('span').addClass(
                                'invalid-feedback')
                            .html(error['message'])
                    } else {
                        $('#message').removeClass('is-invalid').siblings('span').removeClass(
                            'invalid-feedback').html('')
                    }
                }


            }
        })
    })
    </script>
    <!-- javascript link  -->
    @endsection