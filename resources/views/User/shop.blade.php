@extends('User.master')
@section('css')
<link rel="stylesheet" href="{{asset('asset/user/ion.rangeSlider.min.css')}}">
@endsection
@section('content')
<!-- service first section -->
<div class="Product-home-section sec10-dark">
    <div class="Product-sub-section sec7-dark">
        <h1 class="dark-icon">Product</h1>
        <div>
            <a href="./index.html" class="dark-anchor">Home</a>
            <span class="dark-icon">/</span>
            <a href="./Product.html" class="dark-anchor">Product</a>
        </div>
    </div>
</div>
<!-- service first section -->
<div class="shop-main">
    <div class="filter-button-container">
        <button id="Toggle-Filter">
            <span>Filters</span>
        </button>
    </div>
    <div class="shop-left-site">
        <div class="prdouct-left-cart">
            <h2 class="nav-nigth">Cart</h2>
            <div class="product-left-underllne"></div>
            <p>
                @if(Cart::count() > 0)
                <a href="{{ route('Cart') }}" class="nav-nigth">{{ Cart::count() }} Product in Cart</a>
                @else
                <a href="{{ route('Cart') }}" class="nav-nigth">No Product in Cart</a>
                @endif
            </p>
        </div>
        <div class="product-left-filter">
            <h2 class="nav-nigth">Bikes</h2>
            <div class="product-left-underllne"></div>
            @if($categories->isNotEmpty())
            @foreach($categories as $category)
            <p><a href="{{route('shop',$category->slug)}}"
                    class="{{($categoryID == $category->id ? 'active' : '')}} nav-nigth">{{$category->name}}</a></p>
            @endforeach
            @else
            <p><a href="">Categories Not Found </a></p>
            @endif
        </div>
        <div class="product-left-price">
            <h2 class="nav-nigth">Price (Rs)</h2>
            <div class="product-left-underllne"></div>
            <input type="text" class="js-range-slider" name="my_range" value="" />
        </div>
        <div class="product-left-filter">
            <h2 class="nav-nigth">Gender</h2>
            <div class="product-left-underllne"></div>
            <p>
                <input {{(in_array('men',$genderArray)) ? 'checked' : '' }} type="checkbox" class="gender-label"
                    name="gender" id="gender-1" value="men">
                <label class="form-check-label nav-nigth" for="gender-1">
                    Men
                </label>

            </p>
            <p>
                <input {{(in_array('women',$genderArray)) ? 'checked' : '' }} type="checkbox" class="gender-label"
                    name="gender" id="gender-2" value="women">
                <label class="form-check-label nav-nigth" for="gender-2">
                    Women
                </label>

            </p>
            <p>
                <input {{(in_array('kid',$genderArray)) ? 'checked' : '' }} type="checkbox" class="gender-label"
                    name="gender" id="gender-3" value="kid">
                <label class="form-check-label nav-nigth" for="gender-3">
                    Kid
                </label>

            </p>
        </div>
        <div class="product-left-brand">
            <h2 class="nav-nigth">Brand</h2>
            <div class="product-left-underllne">
            </div>
            @if($brands->isNotEmpty())
            @foreach($brands as $brand)
            @php
            $brandId = $brand->id;
            @endphp
            <p>
                <input {{(in_array($brandId,$brandArray)) ? 'checked' : '' }} type="checkbox" class="brand-label"
                    name="brand[]" id="brand-{{$brand->id}}" value="{{$brand->id}}">
                <label class="form-check-label nav-nigth" for="brand-{{$brand->id}}">
                    {{$brand->name}}
                </label>
            </p>
            @endforeach
            @else
            <p>
                <span class="nav-nigth">Brands Not Found</span>
            </p>
            @endif
        </div>
        <div class="reset-filter">
            <a href="{{route('shop')}}" class="nav-nigth">Reset Filter</a>
        </div>
    </div>

    <div class="shop-rigth-site">
        <!-- banner section  -->
        <div class="banner-section">
            <div class="sub-banner">
                <h1>OUR DISCOUNT PROGRAM</h1>
                <div></div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmmpor incididunt ut labore et
                    dolore magna aliqua.</p>
                <button class="gear-button"><span>Read More</span></button>
                <h2>30% OFF</h2>
                <span>Lorem ipsum dolor sit.
                </span>
            </div>
        </div>
        <!-- banner section  -->
        <!-- product section  -->
        <div class="product-section two-container">
            <h1 class="nav-nigth">Best Products</h1>
            <div class="sort-section">
                <h2 class="nav-nigth">120 Product</h2>
                <div class="sort-sub">
                    <span class="nav-nigth">Sort By:</span>
                    <select class="sort" name="sort" aria-label="Default select example">
                        <option selected value="">Sorting</option>
                        <option value="latest" {{ ($sort == 'latest') ? 'selected' : '' }}>Latest</option>
                        <option value="price_desc" {{ ($sort == 'price_desc') ? 'selected' : '' }}>Price High</option>
                        <option value="price_asc" {{ ($sort == 'price_asc') ? 'selected' : '' }}>price Low</option>
                    </select>
                    <div>
                        <i class="fa fa-th-large two-card dark-anchor" aria-hidden="true"></i>
                        <i class="fa fa-list one-card  dark-anchor" aria-hidden="true"></i>
                        <i class="fa fa-th three-card dark-anchor" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <div class="product-card-container">
                @if($products->isNotEmpty())
                @foreach($products as $product)
                @php
                $img = $product->image->first()
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
                        <h2 class="sec4-nav-nigth">${{ number_format($product->price,2) }}</h2>
                        <p class="sec8-nav-nigth">{{$product->title}}</p>
                        <a class="gear-button" href="{{route('Product',$product->slug)}}"><span>View More</span></a>
                    </div>
                </div>
                @endforeach
                @else
                <h1>Product Not Found</h1>
                @endif
            </div>
            <div class="card-footer clearfix pagination">
                {{$products->withQueryString()->links()}}
            </div>
        </div>
        <!-- product section  -->
    </div>
</div>
@endsection
@section('js')
<!-- javascript link  -->
<script src="{{asset('asset/user/js/shop.js')}}"></script>
<script src="{{asset('asset/user/js/ion.rangeSlider.min.js')}}"></script>
<script type="text/javascript">
//product filter function
//two card 
$(document).ready(function() {
    $('.two-card').click(function() {
        $('.fourth-card').addClass('fourth-two-card')
    })
})
$(document).ready(function() {
    $('.three-card').click(function() {
        $('.fourth-card').removeClass('fourth-two-card')

    })

})
$(document).ready(function() {
    $('.one-card').click(function() {
        $('.fourth-card').removeClass('fourth-two-card')

    })
})
//two card 
//three card
$(document).ready(function() {
    $('.three-card').click(function() {
        $('.fourth-card').addClass('fourth-three-card')

    })
})
$(document).ready(function() {
    $('.two-card').click(function() {
        $('.fourth-card').removeClass('fourth-three-card')

    })
})
$(document).ready(function() {
    $('.one-card').click(function() {
        $('.fourth-card').removeClass('fourth-three-card')

    })
})
//three card
//one card
$(document).ready(function() {
    $('.one-card').click(function() {
        $('.fourth-card').addClass('fourth-one-card')

    })
})
$(document).ready(function() {
    $('.two-card').click(function() {
        $('.fourth-card').removeClass('fourth-one-card')

    })
})
$(document).ready(function() {
    $('.three-card').click(function() {
        $('.fourth-card').removeClass('fourth-one-card')

    })
})
//one card
//two container

$(document).ready(function() {
    $('.two-card').click(function() {
        $('.two-container').addClass('two-card-container')
    })
})
//two container

//product filter function
rangeSlider = $(".js-range-slider").ionRangeSlider({
    type: "double",
    min: 0,
    max: 10000,
    from: {{ $pricemin }},
    step: 10,
    to:  {{ $pricemax }},
    skin: "round",
    max_postfix: "+",
    prefix: "$",
    onFinish: function() {
        applyfilter()
    }
})

// Price Slider
var slider = $(".js-range-slider").data("ionRangeSlider")
//brand filter


$('.brand-label').change(function() {
    applyfilter()
})

// gender filter
$('.gender-label').change(function() {
    applyfilter()
})

// Sort Filter

$('.sort').change(function() {
    applyfilter()
})


function applyfilter() {
    // brand filter
    var brands = [];
    $('.brand-label').each(function() {
        if ($(this).is(':checked') == true) {
            brands.push($(this).val())
        }
    })

    var url = '{{url()->current()}}?';


    if (brands.length > 0) {
        url += 'brands=' + brands.toString()
    }
    // brand filter

    // gender filter
    var gender = [];
    $('.gender-label').each(function() {
        if ($(this).is(':checked') == true) {
            gender.push($(this).val())
        }
    })

    if (gender.length > 0) {
        url += '&gender=' + gender.toString();
    }
    // gender filter

    // Price filter

    url += "&price_min=" + slider.result.from + "&price_max=" + slider.result.to;

    // Price filter

    // Sort filter
    if ($(".sort").val() != "") {
        url += "&sort=" + $(".sort").val();
    }

    // Sort filter


    window.location.href = url
}
</script>
<!-- javascript link  -->
@endsection