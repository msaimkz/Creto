@extends('User.master')
@section('content')
    <!-- service first section -->
    <div class="service-home-section sec10-dark">
        <div class="service-sub-section sec7-dark">
            <h1 class="dark-icon">Service</h1>
            <div>
                <a href="{{ route('index') }}" class="dark-anchor">Home</a>
                <span class="dark-icon">/</span>
                <a href="./service.html" class="dark-anchor">Service</a>
            </div>
        </div>
    </div>
    <!-- service first section -->

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
    <!-- service contact  -->
    <form class="form" id="FeedBackForm" name="FeedBackForm" method="post">
        <h1 class="nav-nigth">Feedback</h1>
        <div class="service-input">
            <div>
                <input type="text" placeholder="Name" class="dark-input-service form-control" name="name"
                    id="name" autocomplete="off">
                <span></span>
            </div>
            <div>
                <input type="email" placeholder="Email" class="dark-input-service form-control" name="email"
                    id="email" autocomplete="off">
                <span></span>
            </div>

        </div>
        <div>
            <textarea name="message" id="message" cols="20" rows="6" placeholder="message"
                class="dark-input-service form-control" name="message" id="message"></textarea>
            <span></span>
        </div>
        <button class="gear-button" type="submit"><span>Submit</span></button>
    </form>
    <!-- service contact  -->
@endsection
@section('js')
    <!-- javascript link  -->
    <script src="{{ asset('asset/user/js/service.js') }}"></script>
    <!-- javascript link  -->

    <script>
        $('#FeedBackForm').submit(function(event) {
            event.preventDefault();
            $(".loading-container").addClass("active")
            $('button[type=submit]').prop('disabled', true)
            $.ajax({
                url: "{{ route('Send-Feedback') }}",
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

                    $('button[type=submit]').prop('disabled', false)
                    if (response['status'] == true) {
                        $('#name').removeClass('is-invalid').val('').siblings('span').removeClass(
                                'invalid-feedback').html('')
                        $('#email').removeClass('is-invalid').val('').siblings('span').removeClass(
                                'invalid-feedback').html('')
                        $('#message').removeClass('is-invalid').val('').siblings('span').removeClass(
                                'invalid-feedback').html('')
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
@endsection
