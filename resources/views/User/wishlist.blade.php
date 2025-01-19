@extends('User.master')
@section('content')
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
<div class="col-md-12 p-5">
    <div class="card">
        <div class="card-header wishlist">
            <h2 class="h5 mb-0 pt-2 pb-2 nav-nigth">My Wishlist</h2>
        </div>
        <div class="card-body p-4">
            @if(!empty($wishlists))
            @foreach($wishlists as $wishlist)
            @php
            $img = ProductImage($wishlist->product->id);
            @endphp
            <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                <div class="d-block d-sm-flex align-items-start text-center text-sm-start">
                    <a class="d-block flex-shrink-0 mx-auto me-sm-4"
                        href="{{route('Product',$wishlist->product->slug)}}" style="width: 10rem;">
                        @if(!empty($img->image))
                        <img src="{{asset('uploads/product/small/'.$img->image)}}" alt="Product"
                            class="wishlist-item-img">
                        @else
                        <img src="{{asset('asset/img/default.avif')}}" alt="Product" class="wishlist-item-img">
                        @endif
                    </a>
                    <div class="pt-2">
                        <h3 class="product-title fs-base mb-2 Wishlist-item-title"><a
                                href="{{route('Product',$wishlist->product->slug)}}" class="nav-nigth">{{ $wishlist->product->title }}</a>
                        </h3>
                        <div class="fs-lg text-accent pt-2 Wishlist-item-price nav-nigth">
                            ${{ number_format($wishlist->product->price,2) }}</div>
                    </div>
                </div>
                <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                    <button class="btn btn-outline-danger btn-sm" type="button"
                        onclick="RemoveWishlist('{{$wishlist->id}}')"><i
                            class="fas fa-trash-alt me-2"></i>Remove</button>
                </div>
            </div>
            @endforeach
            @endif

        </div>
    </div>
</div>

@endsection

@section('js')
<!-- javascript link  -->
<script src="{{asset('asset/user/js/Product.js')}}"></script>

<script type="text/javascript">
function RemoveWishlist(id) {
    var url = '{{route("Remove-Wishlist","ID")}}';
    var newurl = url.replace('ID', id)
    if (confirm('Are You sure want to delete')) {
        $.ajax({
            url: newurl,
            type: 'delete',
            data: {},
            dataType: 'json',
            success: function(response) {
                if (response.status == true) {
                    window.location.href = "{{route('Wishlist')}}"
                } else {
                    alert(response.msg)
                }
            }
        })
    }
}
</script>

@endsection