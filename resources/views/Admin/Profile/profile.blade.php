@extends('Admin.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Admin Personal Information</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('home') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <form method="post" id="ProfileForm" name="ProfileForm">
                @csrf
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <input type="hidden" id="profileImg" name="profileImg">
                                            <div class="profile-image-container">
                                                @if (!empty($user->profile_img))
                                                    <img id="profile-img-box"
                                                        src="{{ asset('uploads/profile/thumb/' . $user->profile_img) }}"
                                                        alt="">
                                                @else
                                                    <img id="profile-img-box"
                                                        src="{{ asset('uploads/profile/default.png') }}" alt="">
                                                @endif

                                                <div class="dropzone-imag-upload">
                                                    <img src="{{ asset('asset/user/img/Thanks/image-uploads2.png') }}"
                                                        alt="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" id="name" class="form-control"
                                                    placeholder="Enter Your Name" value="{{ old('name', $user->name) }}"
                                                    autofocus autocomplete="name">
                                                <span class="error mt-2">

                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" id="email" class="form-control"
                                                    placeholder="Enter Your Email" value="{{ old('email', $user->email) }}"
                                                    autocomplete="username">
                                                <span class="error mt-2">

                                                </span>


                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="mobile">Phone No</label>
                                                <input type="text" name="mobile" id="mobile" class="form-control"
                                                    placeholder="Enter Your Phone"
                                                    value="{{ old('mobile', $user->mobile) }}">
                                                <span class="error mt-2">

                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (session('status') === 'profile-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray-600">
                                    {{ __('Saved.') }}</p>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Change Password</h2>
                                    <div class="mb-3">
                                        <a href="{{ route('Admin.profile.change-password') }}"
                                            class="btn btn-primary">Change Password</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Delete Account</h2>
                                    <div class="mb-3">
                                        <button class="btn btn-danger" type="button" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">Delete Account</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-5 pt-3">
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </section>
    </div>

    <!-- Bootstrap Modal Structure -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmUserDeletionLabel">Are You Sure You Want To Delete Your Account?</h5>

                </div>
                <div class="modal-body">
                    <p>Once your account is deleted, all of its resources and data will be permanently deleted. Please enter
                        your password to confirm you would like to permanently delete your account.</p>

                    <form method="post" id="DeleteAccountForm" name="DeleteAccountForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" name="password" id="password" placeholder="Password"
                                class="form-control">
                        </div>

                        <div class="d-flex delete-button-container">
                            <button type="button" class="btn btn-primary mr-2" data-bs-dismiss="modal"
                                aria-label="Close">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="{{ asset('asset/admin/plugins/dropzone/dropzone.js') }}"></script>
    <script>
        Dropzone.autoDiscover = false;
        const dropzone = $(".dropzone-imag-upload img").dropzone({
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                    $(".loading-container").addClass("active")

                });
            },
            url: "{{ route('Temp-image') }}",
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif,image/webp",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                $("#profileImg").val(response.Image_id);
                $("#profile-img-box").attr("src", response.Image_path);
                $(".loading-container").removeClass("active")


            }
        });
        $('#ProfileForm').submit(function(event) {
            event.preventDefault();
            var element = $(this)
            $('button[type=submit]').prop('disabled', true)
            $(".loading-container").addClass("active")

            $.ajax({
                url: "{{ route('Admin.profile.update') }}",
                type: 'patch',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $('button[type=submit]').prop('disabled', false)
                    $(".loading-container").removeClass("active")

                    if (response['status'] == true) {
                        $('.error').removeClass('invalid-feedback').html('')
                        $('input').removeClass('is-invalid')
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
                        $('.error').removeClass('invalid-feedback').html('')
                        $('input').removeClass('is-invalid')
                        console.log(error)
                        $.each(error, function(key, value) {
                            $(`#${key}`).addClass('is-invalid').siblings('span').addClass(
                                    'invalid-feedback')
                                .html(value)
                        })

                    }
                },
                error: function(JQXHR, exception) {
                    console.log('Something Error');
                }
            })

        })
        $('#DeleteAccountForm').submit(function(event) {
            event.preventDefault();
            var element = $(this)
            $('button[type=submit]').prop('disabled', true)
            $(".loading-container").addClass("active")

            $.ajax({
                url: "{{ route('Admin.profile.destroy') }}",
                type: 'delete',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $('button[type=submit]').prop('disabled', false)
                    $(".loading-container").removeClass("active")

                    if (response['status'] == true) {
                        $('input').removeClass('is-invalid')
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
                        window.location.href = "{{ route('index') }}"
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
                            title: response['errors']['password']
                        });
                    }
                },
                error: function(JQXHR, exception) {
                    console.log('Something Error');

                }
            })

        })
    </script>
@endsection
