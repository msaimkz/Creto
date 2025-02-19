@extends('Admin.master')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Change Password</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('Admin.profile.edit') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <form method="post" id="changePasswordForm" name="changePasswordForm">
                @csrf
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="current_password">Old Password</label>
                                                <input type="password" name="current_password" id="current_password"
                                                    class="form-control" placeholder="Old Password"
                                                    autocomplete="current-password">
                                                <span class="error"></span>

                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="password">New Password</label>
                                                <input type="password" name="password" id="password"
                                                    class="form-control" placeholder="New Password"
                                                    autocomplete="new-password">
                                                <span class="error"></span>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="confirm_password">Confirm Password</label>
                                                <input type="password" name="password_confirmation" id="password_confirmation"
                                                    class="form-control" placeholder="Confirm Password"
                                                    autocomplete="new-password">

                                            </div>
                                        </div>
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
@endsection
@section('js')
    <script>
        $('#changePasswordForm').submit(function(event) {
            event.preventDefault();
            var element = $(this)
            $('button[type=submit]').prop('disabled', true)
            $(".loading-container").addClass("active")

            $.ajax({
                url: "{{ route('password.update') }}",
                type: 'put',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $('button[type=submit]').prop('disabled', false)
                    $(".loading-container").removeClass("active")
                    

                    if (response['status'] == true) {
                        $('.error').removeClass('invalid-feedback').html('')
                        $('input').removeClass('is-invalid').value('')
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
    </script>
@endsection
