<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Creto | Admin Panel</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('asset/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('asset/admin/css/adminlte.min.css') }}">
    @yield('css')
    <link rel="stylesheet" href="{{ asset('asset/admin/css/custom.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="hold-transition sidebar-mini">

    <!-- Site wrapper -->
    <div class="wrapper">
        <div class="loading-container">
            <div class="loader"></div>
        </div>
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light pr-4">
            <!-- Right navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>


            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link p-0 pr-3" data-toggle="dropdown" href="#">
                        @if (!empty(Auth()->user()->profile_img))
                            <img src="{{ asset('uploads/profile/thumb/' . Auth()->user()->profile_img) }}"
                                class='img-circle elevation-2' width="40" height="40" alt="">
                        @else
                            <img src="{{ asset('asset/admin/img/avatar5.png') }}" class='img-circle elevation-2'
                                width="40" height="40" alt="">
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
                        <h4 class="h4 mb-0"><strong></strong></h4>
                        <div class="">
                            <a href="{{ route('Admin.profile.edit') }}" class="dropdown-item">My Profile</a>
                        </div>

                        <div class="dropdown-divider"></div>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a class="dropdown-item text-danger" :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #192330;">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="brand-link">

                <span class="brand-text font-weight-light">Creto Bicycle Shop</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt" style="color: #FFD910;"></i>
                                <p style="color: #FFF;">Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('category') }}" class="nav-link">
                                <i class="nav-icon fas fa-file-alt" style="color: #FFD910;"></i>
                                <p style="color: #FFF;">Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('brand') }}" class="nav-link">
                                <svg class="h-6 nav-icon w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="#FFD910"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="#FFD910" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <p style="color: #FFF;">Brands</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('Admin-service') }}" class="nav-link">
                                <i class="nav-icon  fas fa-wrench" style="color: #FFD910;"></i>
                                <p style="color: #FFF;">Services</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('product') }}" class="nav-link">
                                <i class="nav-icon fas fa-tag" style="color: #FFD910;"></i>
                                <p style="color: #FFF;">Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('news') }}" class="nav-link">
                                <i class="nav-icon fas fa-newspaper" style="color: #FFD910;"></i>
                                <p style="color: #FFF;">News</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('Shipping') }}" class="nav-link">
                                <!-- <i class="nav-icon fas fa-tag"></i> -->
                                <i class="fas fa-truck nav-icon" style="color: #FFD910;"></i>
                                <p style="color: #FFF;">Shipping</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('order') }}" class="nav-link">
                                <i class="nav-icon fas fa-shopping-bag" style="color: #FFD910;"></i>
                                <p style="color: #FFF;">Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('discount') }}" class="nav-link">
                                <i class="nav-icon  fa fa-percent" aria-hidden="true" style="color: #FFD910;"></i>
                                <p style="color: #FFF;">Discount</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('Admin-team') }}" class="nav-link">
                                <i class="nav-icon  fas fa-users" style="color: #FFD910;"></i>
                                <p style="color: #FFF;">Team Members</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user') }}" class="nav-link">
                                <i class="nav-icon  fas fa-users" style="color: #FFD910;"></i>
                                <p style="color: #FFF;">Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('Rating') }}" class="nav-link">
                                <i class="nav-icon  fas fa-comment" style="color: #FFD910;"></i>
                                <p style="color: #FFF;">Reviews</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('feedback') }}" class="nav-link">
                                <i class="nav-icon  fas fa-comment" style="color: #FFD910;"></i>
                                <p style="color: #FFF;">Feedbacks</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('Subscribers') }}" class="nav-link">
                                <i class="nav-icon  fa-solid fa-font-awesome" style="color: #FFD910;"></i>
                                <p style="color: #FFF;">Subscriber</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{ route('Admin-wishlist') }}" class="nav-link">
                                <i class="nav-icon  fas fa-heart" style="color: #FFD910;"></i>
                                <p style="color: #FFF;">Wishlists</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('Admin-contact') }}" class="nav-link">
                                <i class="nav-icon  fas fa-envelope" style="color: #FFD910;"></i>
                                <p style="color: #FFF;">Contact Emails</p>
                            </a>
                        </li>



                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        @yield('content')

        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2024 CretoBiycleShop All rights reserved.
        </footer>

    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="{{ asset('asset/admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('asset/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('asset/admin/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('asset/admin/js/demo.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('js')

</body>

</html>
