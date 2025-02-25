@extends('User.master')
@section('content')
    <section class="section-11">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2 password-heading">Change Password</h2>
                        </div>
                        <div class="card-body p-4">
                            <form method="post" id="changePasswordForm" name="changePasswordForm">
                                @csrf


                                <div class="row">
                                    <div class="mb-3">
                                        <label class="password-label" for="old_password">Old Password</label>
                                        <input type="password" name="current_password" id="current_password"
                                            placeholder="Old Password" class="form-control password-input"
                                            autocomplete="current-password">
                                        <span class="error"></span>

                                    </div>

                                    <div class="mb-3">
                                        <label class="password-label" for="new_password">New Password</label>
                                        <input type="password" name="password" id="password" placeholder="New Password"
                                            class="form-control password-input" autocomplete="new-password">
                                        <span class="error"></span>

                                    </div>

                                    <div class="mb-3">
                                        <label class="password-label" for="confirm_password">Confirm Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            placeholder="Confirm Password" class="form-control password-input"
                                            autocomplete="new-password">
                                        <span class="error"></span>

                                    </div>

                                    <div class="d-flex password-button-container">
                                        <button type="submit" class="btn password-button">Save</button>
                                        <a href="{{ route('profile.edit') }}" class="btn password-button">Back</a>
                                    </div>


                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
                        $('input').removeClass('is-invalid').val('')
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
