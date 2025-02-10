@extends('User.master')
@section('content')
<!-- service first section -->
<div class="Product-home-section sec10-dark">
    <div class="Product-sub-section sec7-dark">
        <h1 class="dark-icon">About Us</h1>
        <div>
            <a href="{{ route('index') }}" class="dark-anchor">Home</a>
            <span class="dark-icon">/</span>
            <a href="{{ route('about')}}" class="dark-anchor">About Us</a>
        </div>
    </div>
</div>
<!-- service first section -->

<!-- about second section -->
<div class="about-second-section">
    <h1 class="nav-nigth">Our Advantages</h1>

    <div class="about-second-container">
        <div class="about-banner">
            <img src="{{asset('asset/user/img/about/banner1.jpg')}}" alt="">
            <h2 class="nav-nigth">Lorem ipsum dolor sit amet consectetur</h2>
            <p class="nav-nigth">Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, natus praesentium
                amet
                temporibus eos laudantium!</p>
        </div>
        <div class="about-banner">
            <img src="{{asset('asset/user/img/about/banner2.jpg')}}" alt="">
            <h2 class="nav-nigth">Lorem ipsum dolor sit amet consectetur</h2>
            <p class="nav-nigth">Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, natus praesentium
                amet
                temporibus eos laudantium!</p>
        </div>
    </div>
</div>
<!-- about second section -->
<!-- third section  -->
<div class="third-section">
    <div class="tird-icon-box-container">
        <div class="tird-icon-box">
            <i class="fa-solid fa-dolly dark-icon"></i>
            <h1>free shipping <br> from $500 </h1>
        </div>
        <div class="tird-icon-box">
            <i class="fa-solid fa-gear dark-icon"></i>
            <h1>Warrenty Service for 3 Months </h1>
        </div>
        <div class="tird-icon-box">
            <i class="fa-solid fa-clone dark-icon"></i>
            <h1>Exchange Return <br> Within 14 Days</h1>
        </div>
        <div class="tird-icon-box">
            <i class="fa-solid fa-gift dark-icon"></i>
            <h1>Discount for Coustumer</h1>
        </div>
    </div>
</div>
<!-- third section  -->
<!-- fourth section  -->
<div class="about-count-down-section">
    <div class="count-down-container">
        <div class="count-down-card">
            <span class="num" data-val="{{ (!empty($customers) ? $customers : 0 ) }}">0000</span>
            <div></div>
            <h2>Customer</h2>
        </div>
        <div class="count-down-card">
            <span class="num" data-val="{{ (!empty($orders) ? $orders : 0 ) }}">0000</span>
            <div></div>
            <h2>Complete Orders</h2>
        </div>
        <div class="count-down-card">
            <span class="num" data-val="{{ (!empty($products) ? $products : 0 ) }}">000</span>
            <div></div>
            <h2>Products</h2>
        </div>
        <div class="count-down-card">
            <span class="num" data-val="{{ $brands }}">000</span>
            <div></div>
            <h2>Brands</h2>
        </div>
    </div>
</div>
<!-- fourth section  -->
<!-- fifth section  -->
<div class="about-fifth-section">
    <h1 class="nav-nigth">our teams</h1>
    <div class="fifth-container">
        @if(!empty($members))

        @foreach($members as $member)
        <div class="fifth-card">
            @if($member->img != null)
            <img src="{{asset('uploads/team/thumb/'.$member->img)}}" alt="">
            @else
            <img src="{{asset('asset/img/default.avif')}}" alt="">
            @endif
            <h2 class="nav-nigth">{{ $member->name }}</h2>
            <span class="nav-nigth">{{ $member->designation }}</span>
            <div class="fifth-card-icon">
                @if($member->facebook_url != null)
                <a  target="_blank" href="{{ url($member->facebook_url) }}" >
                    <i class="fa-brands fa-facebook-f dark-anchor"></i>
                </a>
                @endif
                @if($member->X_url != null)
                <a  target="_blank" href="{{ url($member->X_url) }}">
                    <i class="fa-brands fa-x-twitter dark-anchor"></i>

                </a>
                @endif
                @if($member->instagram_url != null)
                <a  target="_blank" href="{{ url($member->instagram_url) }}">
                    <i class="fa-brands fa-instagram dark-anchor"></i>
                </a>
                @endif
                @if($member->youtube_url != null)
                <a  target="_blank" href="{{ url($member->youtube_url) }}">
                    <i class="fa-brands fa-youtube dark-anchor"></i>
                </a>
                @endif

            </div>
        </div>

        @endforeach

        @endif


    </div>
</div>
<!-- fifth section  -->
<!-- seveth-section  -->
@if(!empty($feedbacks))
<div class="section7">
    <div class="sec7-content-box sec7-dark">
        <h1>Feedback</h1>
        <div class="swiper mySwier" id="blog">
            <div class="swiper-wrapper">
                @foreach($feedbacks as $feedback)
                @php
                $img = Profileimg($feedback->user_id)
                @endphp
                <div class="swiper-slide" id="blog-slide">
                    <div class="blog-content blog-dark">
                        <p class="nav-nigth">{{ $feedback->message }}</p>
                        <div class="blog-name">


                            <div class="blog-img">
                                @if($img != null)
                                <img src="{{ asset('uploads/profile/thumb/'.$img) }}" alt="">
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
<!-- ninth section  -->
<div class="section9">
    <img src="{{asset('asset/user/img/Home1/brand1.svg')}}" alt="">
    <img src="{{asset('asset/user/img/Home1/brand2.svg')}}" alt="">
    <img src="{{asset('asset/user/img/Home1/brand3.svg')}}" alt="">
    <img src="{{asset('asset/user/img/Home1/brand4.svg')}}" alt="">
    <img src="{{asset('asset/user/img/Home1/brand5.svg')}}" alt="">

</div>
<!-- ninth section  -->
@endsection


@section('js')
<!-- javascript link  -->
<script src="{{asset('asset/user/js/about.js')}}"></script>
<!-- javascript link  -->
@endsection