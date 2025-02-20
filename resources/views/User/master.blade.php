<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creto</title>
    <!-- swiper link  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- swiper link  -->

    <!-- font-awesome link   -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- font-awesome link   -->

    <!-- bootstrap link  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- bootstrap link  -->

    @yield('css')

    <!-- css link  -->
    <link rel="stylesheet" href="{{ asset('asset/user/style.css') }}">
    <!-- css link  -->

    <!-- CSRF Token  -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSRF Token  -->

</head>

<body>
    <div class="main">
        <div class="loading-container">
            <div class="loader"></div>
        </div>
        <!-- navbar  -->
        <div class="nav-top">
            <div class="dark-icon">
                <div class="toggle">
                    <i class="fa-solid fa-moon" id="moon"></i>
                    <i class="fa-solid fa-sun" id="sun"></i>
                </div>
            </div>
            <div class="nav-top-icon">
                @if (Auth::check() == true)
                    <div class="nav-top-item">
                        <a href="{{ route('Wishlist') }}">
                            <i class="fa-solid fa-heart sec4-dark-icon"></i>
                        </a>
                    </div>
                    <div class="nav-top-item dropdown">
                        <a href="" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-user sec4-dark-icon"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ route('Order') }}">My Orders</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">My Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" id="Logout">
                                    @csrf
                                    <a class="dropdown-item text-danger" :href="route('logout')"
                                        onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        Logout
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <div class="nav-top-item">
                        <a href="{{ route('Cart') }}">
                            <i class="fa-solid fa-cart-shopping sec4-dark-icon"></i></a>
                    </div>
                @else
                    <div class="nav-top-item">
                        <a href="{{ route('login') }}">
                            <span>Sign In</span></a>
                    </div>

                    <div class="nav-top-item">
                        <a href="{{ route('Cart') }}">
                            <i class="fa-solid fa-cart-shopping sec4-dark-icon"></i></a>
                    </div>
                @endif
            </div>
        </div>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand text-danger" href="{{ route('index') }}">
                    <img src="{{ asset('asset/user/img/Home1/logo1.svg') }}" class="logo-img-one" alt="">
                    <img src="{{ asset('asset/user/img/Home1/logo41.svg') }}" class="logo-img" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="fa-solid fa-bars sec4-dark-icon"></i>
                    </span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active dark-anchor" aria-current="page"
                                href="{{ route('index') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active dark-anchor" aria-current="page"
                                href="{{ route('service') }}">Service</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active dark-anchor" aria-current="page"
                                href="{{ route('shop') }}">Shop</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active dark-anchor" aria-current="page"
                                href="{{ route('gallery') }}">Gallery</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle dark-anchor" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Pages
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('about') }}">About Us</a></li>
                                <li><a class="dropdown-item" href="{{ route('News') }}">News</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active dark-anchor" aria-current="page"
                                href="{{ route('contact') }}">Contact</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
        <!-- navbar  -->

        @yield('content')

        <footer>
            <div class="footer-content">
                <h2 class="nav-nigth">Subscribe</h2>
                <p class="nav-nigth">Subscribe us and you won't miss the new arrivals, as well as discounts and sales.
                </p>

                <h2 class="nav-nigth">Stay In Touch</h2>
                <div class="footer-icon">
                    <a href="https://www.facebook.com/" target="blank"> <i
                            class="fa-brands fa-facebook-f dark-anchor"></i></a>
                    <a href="https://www.twitter.com/" target="blank"> <i
                            class="fa-brands fa-x-twitter dark-anchor"></i></a>
                    <a href="https://www.instagram.com/" target="blank"> <i
                            class="fa-brands fa-instagram dark-anchor"></i></a>
                    <a href="https://www.youtube.com/" target="blank"> <i
                            class="fa-brands fa-youtube dark-anchor"></i></a>
                </div>
                <p>Questions? Please write us at <a href="#" class="dark-anchor">creto@gmail.com</a></p>
            </div>
            <div class="footer-link">
                <div class="fooer-sub-link">
                    <h2 class="nav-nigth">Info</h2>
                    <div class="footer-anchor-container">
                        <div class="footer-anchor">
                            <a href="{{ route('index') }}" class="dark-anchor">Home</a>
                            <a href="{{ route('service') }}" class="dark-anchor">Service</a>
                            <a href="{{ route('shop') }}" class="dark-anchor">Shop</a>
                            <a href="{{ route('gallery') }}" class="dark-anchor">Gallery</a>
                        </div>
                        <div class="footer-anchor">
                            <a href="{{ route('about') }}" class="dark-anchor">About us</a>
                            <a href="{{ route('News') }}" class="dark-anchor">News</a>


                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- jquery script link -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <!-- jquery script link -->

    <!-- swiper script link  -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- swiper script link  -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('.toggle').click(function() {
                $('.toggle').toggleClass('active')
                $('body').toggleClass('nigth')
                $('.nav-nigth').toggleClass('nav-dark')
                $('.dark-card').toggleClass('dark-back')
                $('.gear-button').toggleClass('nigth-button')
                $('.card-dark').toggleClass('dark')
                $('.dark-icon').toggleClass('icon')
                $('.green-card').toggleClass('text')
                $('.blog-dark').toggleClass('blog-nigth')
                $('.sec7-dark').toggleClass('sec7-nigth')
                $('.sec8-dark').toggleClass('sec8-nigth')
                $('.sec8-nav-nigth').toggleClass('sec8-nav-text')
                $('.sec4-nav-nigth').toggleClass('sec4-nav-text')
                $('.card-dark-img').toggleClass('dark-img')
                $('.dark-filter').toggleClass('nigth-filter')
                $('.sec4-dark-icon').toggleClass('sec4-nigth-icon')
                $('.dark-anchor').toggleClass('nigth-anchor')
                $('.sec10-dark').toggleClass('sec10-nigth')
                $('.sc10-dark-img').toggleClass('sc10-nigth-img')
                $('.sec10-dark-text').toggleClass('sec10-nigth-text')
                $('.dark-shopping').toggleClass('nigth-shopping')
                $('.dark-close').toggleClass('nigth-close')
                $('.dark-cursor').toggleClass('nigth-cursor')
                $('.contact-dark-card').toggleClass('contact-nigth-card')
                $('.dark-input-service').toggleClass('nigth-input-service')
                $('.dark-input-service').toggleClass('nigth-input-service')
                $('.cart-header').toggleClass('nigth-cart-header')

                $('.comment-content>p>p').toggleClass('nav-nigth')
            })

        })


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    @yield('js')
</body>

</html>
