@extends('User.master')
@section('content')


    <!-- first-section -->
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide dark-slider" id="slide-1">
                <div class="content-box">
                    <h1 class="nav-nigth">Best Bike For You</h1>
                    <p class="nav-nigth">Ride with confidence on the best bikes, engineered for performance, comfort, and
                        style.</p>
                    <a href="{{ route('shop') }}" class="gear-button"><span>Buy Now</span></a>
                </div>
                <div class="img-box">
                    <img src="{{ asset('asset/user/img/Home1/slider1.png') }}" alt="">
                </div>
            </div>
            <div class="swiper-slide dark-slider" id="slide-2">
                <div class="content-box">
                    <h1 class="nav-nigth">Best Bike For You</h1>
                    <p class="nav-nigth">Ride with confidence on the best bikes, engineered for performance, comfort, and
                        style.</p>
                    <a href="{{ route('shop') }}" class="gear-button"><span>Buy Now</span></a>

                </div>
                <div class="img-box">
                    <img src="{{ asset('asset/user/img/Home1/slider2.png') }}" alt="">
                </div>
            </div>
            <div class="swiper-slide dark-slider" id="slide-3">
                <div class="content-box">
                    <h1 class="nav-nigth">Best Bike For You</h1>
                    <p class="nav-nigth">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos architecto
                        voluptatem,
                        itaque sit aperiam dolor.</p>
                    <a href="{{ route('shop') }}" class="gear-button"><span>Buy Now</span></a>

                </div>
                <div class="img-box">
                    <img src="{{ asset('asset/user/img/Home1/slider3.png') }}" alt="">
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <!-- first-section -->
    <!-- second-section -->
    <div class="second-section">
        @if (!empty($services))
            @foreach ($services as $service)
                <div class="card dark-card">
                    <div class="card-content"
                        style="background-image: url('{{ asset("uploads/Service/thumb/{$service->img}") }}');">
                        <h1 class="nav-nigth">{{ $service->title }}</h1>
                        <a href="{{ route('Service-Detail', $service->slug) }}" class="gear-button service-button">View
                            More</a>
                    </div>
                </div>
            @endforeach
        @else
            <h1>Service No Found</h1>
        @endif

    </div>
    <!-- second-section -->
    <!-- third section  -->
    <div class="third-section">
        <div class="tird-icon-box-container">
            <div class="tird-icon-box">
                <i class="fa-solid fa-dolly dark-icon"></i>
                <h1>free shipping <br> from $2500 </h1>
            </div>
            <div class="tird-icon-box">
                <i class="fa-solid fa-gear dark-icon"></i>
                <h1>Warrenty Service for 3 Months </h1>
            </div>
            <div class="tird-icon-box">
                <i class="fa-solid fa-clone dark-icon"></i>
                <h1>Exchange <br> Within 14 Days</h1>
            </div>
            <div class="tird-icon-box">
                <i class="fa-solid fa-gift dark-icon"></i>
                <h1>Discount for Coustumer</h1>
            </div>
        </div>
    </div>
    <!-- third section  -->
    <!-- fourth section  -->
    <div class="fouth-section">
        <div class="fourt-head-section">
            <h1 class="nav-nigth">Our Products</h1>
            <div class="button-container">
                <a href="{{ route('index') }}" class="dark-filter">
                    <span>All</span>
                </a>
                @if ($categories->isNotEmpty())
                    @foreach ($categories as $category)
                        <a href="{{ route('index', $category->slug) }}"
                            class="dark-filter {{ $categoryID == $category->id ? 'active' : '' }}">
                            <span>{{ $category->name }}</span>
                        </a>
                    @endforeach
                @else
                    <a class="dark-filter">
                        <span>category Not Found</span>
                    </a>
                @endif
            </div>
        </div>
        <div class="fourth-card-container">
            @if ($products->isNotEmpty())
                @foreach ($products as $product)
                    @php
                        $img = $product->image->first();
                    @endphp
                    <div class="fourth-card">
                        <div class="fourth-img-box card-dark-img">
                            @if (!empty($img->image))
                                <img src="{{ asset('uploads/product/small/' . $img->image) }}" class="img-thumbnail"
                                    width="50">
                                </td>
                            @else
                                <img src="{{ asset('asset/img/default.avif') }}" class="img-thumbnail" width="50"></td>
                            @endif
                        </div>
                        <div class="fourth-content-box card-dark">
                            <h2 class="sec4-nav-nigth">${{ $product->price }}</h2>
                            <p class="sec8-nav-nigth">{{ $product->title }}</p>
                            <a class="gear-button" href="{{ route('Product', $product->slug) }}"><span>View More</span></a>
                        </div>
                    </div>
                @endforeach
            @else
                <h1 class="Not-found">Product Not Found</h1>
            @endif
        </div>
    </div>
    <!-- fourth section  -->
    <!-- fifth section  -->
    <div class="fifth-section">
        <div class="fifth-cross"></div>
        <div class="fifth-content">
            <div class="fifth-email">
                <h1>Subscribe</h1>
                <p>Subscribe us and you won't miss the new arrivals, as well as discounts and sales.</p>
                <div>
                    <form action="" id="SubscribeForm" name="SubscribeForm">
                        <div>
                            <input type="email" class="email" name="email" placeholder=" @ Email">
                        </div>
                        <button class="gear-button"><span>Send</span></button>
                    </form>
                </div>
            </div>
            <div class="fifth-img">
                <img src="{{ asset('asset/user/img/Home1/bicycle09.png') }}" alt="">
            </div>
        </div>TopProduct
    </div>
    <!-- fifth section  -->
    <!-- sixth section  -->
    <div class="sixth-section">
        <h1 class="nav-nigth">Top Sale</h1>
        <div class="sixth-card-container">
            @if (!empty($TopProducts))
                @foreach ($TopProducts as $TopProduct)
                    @php
                        $img = $TopProduct->image->first();
                    @endphp
                    <div class="sixth-card">
                        <div class="sixth-img-box card-dark-img">
                            @if (!empty($img->image))
                                <img src="{{ asset('uploads/product/small/' . $img->image) }}">
                                </td>
                            @else
                                <img src="{{ asset('asset/img/default.avif') }}" class="img-thumbnail" width="50"></td>
                            @endif
                        </div>
                        <div class="sixth-content-box card-dark">
                            <h2 class="sec4-nav-nigth">${{ $TopProduct->price }}</h2>
                            <p class="sec8-nav-nigth">{{ $TopProduct->title }}</p>
                            <a class="gear-button" href="{{ route('Product', $TopProduct->slug) }}"><span>View
                                    More</span></a>
                        </div>
                    </div>
                @endforeach
            @else
                <h1 class="Not-found">Product Not Found</h1>
            @endif
        </div>
    </div>
    <!-- sixth section  -->
    <!-- seveth-section  -->
    @if (!empty($feedbacks))
        <div class="section7">
            <div class="sec7-content-box sec7-dark">
                <h1>Feedback</h1>
                <div class="swiper mySwier" id="blog">
                    <div class="swiper-wrapper">
                        @foreach ($feedbacks as $feedback)
                            @php
                                $img = Profileimg($feedback->user_id);
                            @endphp
                            <div class="swiper-slide" id="blog-slide">
                                <div class="blog-content blog-dark">
                                    <p class="nav-nigth">{{ $feedback->message }}</p>
                                    <div class="blog-name">


                                        <div class="blog-img">
                                            @if ($img != null)
                                                <img src="{{ asset('uploads/profile/thumb/' . $img) }}" alt="">
                                            @else
                                                <img src="{{ asset('uploads/profile/default.png') }}" alt="">
                                            @endif
                                        </div>
                                        <div class="blog-rating">
                                            <h3 class="nav-nigth">{{ $feedback->name }}</h3>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination" id="Blog-pag"></div>
                </div>
                <!-- seveth-section  -->

            </div>
        </div>
    @endif
    <!-- seveth-section  -->
    <!-- eight section  -->
    @if (!empty($news))
        <div class="section8">
            <h1 class="nav-nigth"> Our News</h1>
            <div class="sec8-card-container">

                @foreach ($news as $new)
                    <div class="sec8-card sec8-dark">
                        <h2 class="sec8-nav-nigth">{{ $new->title }}</h2>
                        <div class="sec8-card-imgbox">
                            <img src="{{ asset('uploads/News/thumb/small/' . $new->img) }}" alt="">
                            <div class="blackshadow"></div>
                        </div>
                        <div class="sec8-card-contentbox">
                            <div class="time-box">
                                <i class="fa-solid fa-calendar-days sec4-dark-icon"></i>
                                <span class="nav-nigth">dec 15 2023</span>
                                <i class="fa-solid fa-user sec4-dark-icon"></i>
                                <span class="nav-nigth ">By {{ $new->writer }}</span>
                            </div>
                            <p class="nav-nigth">{!! $new->short_descripion !!}</p>
                            <a href="{{ route('Blog-Detail', $new->id) }}" class="dark-anchor">Read More</a>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    @endif
    <!-- eight section  -->
    <!-- ninth section  -->
    <div class="section9">
        <img src="{{ asset('asset/user/img/Home1/brand1.svg') }}" alt="">
        <img src="{{ asset('asset/user/img/Home1/brand2.svg') }}" alt="">
        <img src="{{ asset('asset/user/img/Home1/brand3.svg') }}" alt="">
        <img src="{{ asset('asset/user/img/Home1/brand4.svg') }}" alt="">
        <img src="{{ asset('asset/user/img/Home1/brand5.svg') }}" alt="">

    </div>
    <!-- ninth section  -->
    <!-- ten section  -->
    <div class="section10 sec10-dark">
        @if (!empty($coupon))
            <div class="sec10-content">
                <div class="sec10-count-box">
                    <h1>{{ $coupon->name }}</h1>
                    <p>Use This Coupon and get @if ($coupon->type == 'percent')
                            {{ $coupon->discount_amount }}%
                        @else
                            ${{ $coupon->discount_amount }}
                        @endif
                        Discount For Shopping
                    </p>
                    <div id="price">
                        <h2 class="sec10-dark-text">Coupon Code</h2>
                        <span>{{ $coupon->code }}</span>

                    </div>
                    <div class="timer">
                        <div class="border-line">
                            <span id="days">00</span>
                            <h2 class="sec10-dark-text">Days</h2>
                        </div>
                        <div class="border-line">
                            <span id="hours">00</span>
                            <h2 class="sec10-dark-text">Hours</h2>
                        </div>
                        <div class="border-line">
                            <span id="minutes">00</span>
                            <h2 class="sec10-dark-text">Minutes</h2>
                        </div>
                        <div>
                            <span id="seconds">00</span>
                            <h2 class="sec10-dark-text">Seconds</h2>
                        </div>
                    </div>
                </div>
                <div class="sec10-imgbox sc10-dark-img">
                    <img src="{{ asset('asset/user/img/Home1/views1.png') }}" alt="">
                </div>
            </div>
        @else
            <div class="sec10-content">
                <div class="sec10-count-box">
                    <h1>HYPER E-RIDE BIKE 700C</h1>
                    <p>Maecenas consequat ex id lobortis venenatis. Mauris id erat enim. Morbi dolor dolor, auctor tincidunt
                        lorem.</p>
                    <div id="price">
                        <h2 class="sec10-dark-text">$200.34</h2>

                    </div>
                    <div class="timer">
                        <div class="border-line">
                            <span id="days">00</span>
                            <h2 class="sec10-dark-text">Days</h2>
                        </div>
                        <div class="border-line">
                            <span id="hours">00</span>
                            <h2 class="sec10-dark-text">Hours</h2>
                        </div>
                        <div class="border-line">
                            <span id="minutes">00</span>
                            <h2 class="sec10-dark-text">Minutes</h2>
                        </div>
                        <div>
                            <span id="seconds">00</span>
                            <h2 class="sec10-dark-text">Seconds</h2>
                        </div>
                    </div>
                </div>
                <div class="sec10-imgbox sc10-dark-img">
                    <img src="{{ asset('asset/user/img/Home1/views1.png') }}" alt="">
                </div>
            </div>
        @endif
    </div>
    <!-- ten section  -->
    <!-- section 11  -->
    <div class="section11">
        <div class="sec11-card">
            <div class="sec11-img">
                <img src="{{ asset('asset/user/img/Home1/views2.jpg') }}" alt="">
            </div>
            <div class="sec11-content">
                <div>
                    <span>
                        155
                        <i class="fa-regular fa-message"></i>
                    </span>
                </div>
                <div>
                    <span>
                        100
                        <i class="fa-regular fa-heart"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="sec11-card">
            <div class="sec11-img">
                <img src="{{ asset('asset/user/img/Home1/views3.jpg') }}" alt="">
            </div>
            <div class="sec11-content">
                <div>
                    <span>
                        155
                        <i class="fa-regular fa-message"></i>
                    </span>
                </div>
                <div>
                    <span>
                        100
                        <i class="fa-regular fa-heart"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="sec11-card">
            <div class="sec11-img">
                <img src="{{ asset('asset/user/img/Home1/views4.jpg') }}" alt="">
            </div>
            <div class="sec11-content">
                <div>
                    <span>
                        155
                        <i class="fa-regular fa-message"></i>
                    </span>
                </div>
                <div>
                    <span>
                        100
                        <i class="fa-regular fa-heart"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="sec11-card">
            <div class="sec11-img">
                <img src="{{ asset('asset/user/img/Home1/views5.jpg') }}" alt="">
            </div>
            <div class="sec11-content">
                <div>
                    <span>
                        155
                        <i class="fa-regular fa-message"></i>
                    </span>
                </div>
                <div>
                    <span>
                        100
                        <i class="fa-regular fa-heart"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="sec11-card">
            <div class="sec11-img">
                <img src="{{ asset('asset/user/img/Home1/views6.jpg') }}" alt="">
            </div>
            <div class="sec11-content">
                <div>
                    <span>
                        155
                        <i class="fa-regular fa-message"></i>
                    </span>
                </div>
                <div>
                    <span>
                        100
                        <i class="fa-regular fa-heart"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- section 11  -->
@endsection
@section('js')
    <!-- javascript link  -->
    <script>
        var couponCode =
            "{{ !empty($coupon->expire_at) ? \Carbon\Carbon::parse($coupon->expire_at)->format('M d, Y h:i:s') : 'Aug 30, 2024 12:33:23' }}";
        console.log(couponCode);
    </script>

    <script src="{{ asset('asset/user/js/script.js') }}"></script>
    <!-- javascript link  -->

    <script>
        $('#SubscribeForm').submit(function(e) {
            e.preventDefault()
            $(".loading-container").addClass("active")
            $.ajax({
                url: "{{ route('Store-Subscriber') }}",
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $(".loading-container").removeClass("active")
                    if (response.isLogin == false) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Toast.fire({
                            icon: "error",
                            title: response["msg"]
                        });
                    }

                    if (response.status == true) {

                        $(".email").val('')
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Toast.fire({
                            icon: "success",
                            title: response["msg"]
                        });
                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Toast.fire({
                            icon: "error",
                            title: response.error['email']
                        });
                    }
                }
            })
        })
    </script>
@endsection
