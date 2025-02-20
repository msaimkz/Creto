@extends('User.master')
@section('content')
    <!-- service first section -->
    <div class="Product-home-section sec10-dark">
        <div class="Product-sub-section sec7-dark">
            <h1 class="dark-icon">Contact Us</h1>
            <div>
                <a href="{{ route('index') }}" class="dark-anchor">Home</a>
                <span class="dark-icon">/</span>
                <a href="{{ route('contact') }}" class="dark-anchor">Contact Us</a>
            </div>
        </div>
    </div>

    <!-- service first section -->
    <!-- contact second-section  -->
    <div class="contact-second-section">
        <img src="{{ asset('asset/user/img/contact/contact1.jpg') }}" alt="">
        <div class="contact-second-contact-box">
            <h1 class="nav-nigth">CONTACT INFORMATION</h1>

            <p class="nav-nigth">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum eveniet libero tempore perspiciatis
                modi porro id? Eos nihil aut totam dolore repellat sunt illo, consectetur velit quia aliquid
                aspernatur, esse fugiat cumque dolorum maiores at?
            </p>

            <p class="nav-nigth">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci at itaque similique debitis
                repellat
                nesciunt odit nam eius neque mollitia iste nostrum, molestias id commodi illum dolor esse,
                distinctio ad
                blanditiis, tempora praesentium quas excepturi facilis harum.
            </p>
            <div class="contact-icon-box">
                <i class="fa-brands fa-facebook-f dark-anchor"></i>
                <i class="fa-brands fa-x-twitter dark-anchor"></i>
                <i class="fa-brands fa-instagram dark-anchor"></i>
                <i class="fa-brands fa-youtube dark-anchor"></i>
            </div>
        </div>
    </div>
    <!-- contact second-section  -->

    <!-- contact third section  -->
    <div class="contact-third-section">
        <div class="contact-card contact-dark-card">
            <div class="contact-card-icon">

                <i class="fa-solid fa-phone-volume dark-icon"></i>
                <span>Need help</span>

            </div>
            <div class="contact-card-text">
                <span class="dark-anchor">1-800-488-6040</span>
                <span class="dark-anchor">1-450-438-6570</span>
            </div>
        </div>
        <div class="contact-card contact-dark-card">
            <div class="contact-card-icon">

                <i class="fa-solid fa-envelope dark-icon"></i>
                <span>Question</span>

            </div>
            <div class="contact-card-text">
                <span class="dark-anchor">team@gmail.com</span>
                <span class="dark-anchor">help@gmail.com</span>
            </div>
        </div>
        <div class="contact-card contact-dark-card">
            <div class="contact-card-icon">

                <i class="fa-solid fa-location-dot dark-icon"></i>
                <span>Address</span>

            </div>
            <div class="contact-card-text">
                <span class="dark-anchor">Lorem Street, Chicago</span>
            </div>
        </div>
    </div>
    <!-- contact third section  -->
    <!-- service contact  -->
    <form class="form" id="ContactForm" name="ContactForm" method="post">
        <h1 class="nav-nigth">Contact Us</h1>
        <div class="service-input">
            <div>
                <input type="text" placeholder="Name" class="dark-input-service form-control" name="name"
                    id="name" autocomplete="off">
                <span></span>
            </div>
            <div>
                <input type="text" placeholder="Phone Number" class="dark-input-service form-control" name="phone"
                    id="phone" autocomplete="off">
                <span></span>
            </div>

            <div>
                <input type="text" placeholder="Email" class="dark-input-service form-control" name="email"
                    id="email" autocomplete="off">
                <span></span>
            </div>

        </div>
        <div>
            <textarea name="message" id="message" cols="30" rows="6" placeholder="message"
                class="dark-input-service form-control" name="message" id="message"></textarea>
            <span></span>
        </div>
        <button class="gear-button" type="submit"><span>Submit Commit</span></button>
    </form>
    <!-- service contact  -->

    <!-- contact map section  -->
    <div class="contact-map-section">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14477.210243813175!2d67.13361798829867!3d24.887659230806374!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb33999ec8ecc87%3A0xda9cc5004c86e53f!2sMETRO%20Stargate%2C%20Karachi!5e0!3m2!1sen!2s!4v1705131282104!5m2!1sen!2s"
            style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>

    <!-- contact map section  -->
@endsection
@section('js')
    <script>
        $('#ContactForm').submit(function(event) {
            event.preventDefault();
            $(".loading-container").addClass("active")
            $('button[type=submit]').prop('disabled', true)
            $.ajax({
                url: "{{ route('Send-Contact-Email') }}",
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $(".loading-container").removeClass("active")
                    $('button[type=submit]').prop('disabled', false)
                    if (response['status'] == true) {
                        $('#name').removeClass('is-invalid').val('').siblings('span').removeClass(
                            'invalid-feedback').html('')
                        $('#phone').removeClass('is-invalid').val('').siblings('span').removeClass(
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
                        var error = response['errors']
                        if (error['name']) {
                            $('#name').addClass('is-invalid').siblings('span').addClass(
                                    'invalid-feedback')
                                .html(error['name'])
                        } else {
                            $('#name').removeClass('is-invalid').siblings('span').removeClass(
                                'invalid-feedback').html('')
                        }

                        if (error['phone']) {
                            $('#phone').addClass('is-invalid').siblings('span').addClass(
                                    'invalid-feedback')
                                .html(error['phone'])
                        } else {
                            $('#phone').removeClass('is-invalid').siblings('span').removeClass(
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
