@extends('User.master')
@section('content')
    <section class="section-9 pt-4">
        <div class="container">
            <form action="" method="post" id="OrderForm" name="OrderForm">
                <div class="row" id="checkout-row">
                    <div class="col-md-8" id="checkout-col-1">
                        <div class="sub-title">
                            <h2 id="checkout-title" class="nav-nigth">Shipping Address</h2>
                        </div>
                        <div class="card  border-0">
                            <div class="card-body checkout-form">
                                <div class="row checkout-input-container">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="first_name" id="first_name" class="form-control"
                                                placeholder="First Name"
                                                value="{{ $Customers ? $Customers->first_name : '' }}">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="last_name" id="last_name" class="form-control"
                                                placeholder="Last Name"
                                                value="{{ $Customers ? $Customers->last_name : '' }}">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="email" id="email" class="form-control"
                                                placeholder="Email" value="{{ $Customers ? $Customers->email : '' }}">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <select name="country" id="country" class="form-control">
                                                <option value="">Select a Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ $Customers && $Customers->country_id == $country->id ? 'selected' : '' }}>
                                                        {{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control">{{ $Customers ? $Customers->address : '' }}</textarea>
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="apartment" id="apartment" class="form-control"
                                                placeholder="Apartment, suite, unit, etc. (optional)"
                                                value="{{ $Customers ? $Customers->apartment : '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="city" id="city" class="form-control"
                                                placeholder="City" value="{{ $Customers ? $Customers->city : '' }}">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="state" id="state" class="form-control"
                                                placeholder="State" value="{{ $Customers ? $Customers->state : '' }}">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="zip" id="zip" class="form-control"
                                                placeholder="Zip" value="{{ $Customers ? $Customers->zip : '' }}">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="mobile" id="mobile" class="form-control"
                                                placeholder="Mobile No."
                                                value="{{ $Customers ? $Customers->mobile : '' }}">
                                            <p></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4" id="checkout-col-2">
                        <div class="sub-title">
                            <h2 id="checkout-title" class="nav-nigth">Order Summery</h3>
                        </div>
                        <div class="card cart-summery">
                            <div class="card-body">
                                @foreach (Cart::content() as $item)
                                    <div class="d-flex justify-content-between pb-2">
                                        <div class="h6 nav-nigth">{{ $item->name }} X {{ $item->qty }}</div>
                                        <div class="h5 nav-nigth">${{ number_format($item->price * $item->qty, 2) }}
                                        </div>
                                    </div>
                                @endforeach
                                <div class="d-flex justify-content-between summery-end">
                                    <div class="h6 nav-nigth"><strong>Subtotal</strong></div>
                                    <div class="h5 nav-nigth"><strong>${{ Cart::subtotal(2, '.', ',') }}</strong></div>
                                </div>
                                <div class="d-flex justify-content-between summery-end">
                                    <div class="h6 nav-nigth"><strong>Discount</strong></div>
                                    <div class="h5 nav-nigth"><strong
                                            id="discount">${{ number_format($discount, 2) }}</strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div class="h6 nav-nigth"><strong>Shipping</strong></div>
                                    <div class="h5 nav-nigth"><strong
                                            id="shipping">${{ number_format($shippingcharges, 2) }}</strong>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-2 summery-end">
                                    <div class="h6 nav-nigth"><strong>Total</strong></div>
                                    <div class="h5 nav-nigth"><strong id="grand-total">$
                                            {{ number_format($grandtotal, 2) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="input-group apply-coupan mt-4">
                            <input type="text" placeholder="Coupon Code" class="form-control" id="discount-input">
                            <button class="btn btn-dark" type="button" id="discount-button">Apply Coupon</button>

                        </div>
                        <span class="text-danger" id="coupon-error"></span>

                        @if (Session::has('code'))
                            <div id="discount-wrapper">
                                <div class="mt-4 discount-code">
                                    <strong>{{ Session::get('code.code') }}</strong>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger"
                                        onclick="removeCoupon()">X</a>
                                </div>
                            </div>
                        @endif

                        <div class="pt-4 Pay-button">
                            <button type="submit" class="gear-button" id="pay">Pay Now</button>
                        </div>
                    </div>


                    <!-- CREDIT CARD FORM ENDS HERE -->

                </div>
            </form>
        </div>
        </div>
    </section>
@endsection
@section('js')
    <!-- javascript link  -->
    <script type="text/javascript">
        $("#OrderForm").submit(function(event) {
            event.preventDefault()
            var element = $(this)
            $('#pay').prop('disabled', true)
            $(".loading-container").addClass("active")

            $.ajax({
                url: '{{ route('Proceed') }}',
                type: 'post',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $('#pay').prop('disabled', false)
                    $(".loading-container").removeClass("active")
                    if (response['isError'] == true) {
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

                        window.location.href = "{{ url('/Creto/Thanks/') }}/" + response.orderId


                    } else {
                        var error = response.errors
                        if (error['first_name']) {
                            $('#first_name').addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(error['first_name'])
                        } else {
                            $('#first_name').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('')
                        }

                        if (error['last_name']) {
                            $('#last_name').addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(error['last_name'])
                        } else {
                            $('#last_name').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('')
                        }

                        if (error['email']) {
                            $('#email').addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(error['email'])
                        } else {
                            $('#email').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('')
                        }

                        if (error['country']) {
                            $('#country').addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(error['country'])
                        } else {
                            $('#country').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('')
                        }

                        if (error['address']) {
                            $('#address').addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(error['address'])
                        } else {
                            $('#address').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('')
                        }

                        if (error['city']) {
                            $('#city').addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .html(error['city'])
                        } else {
                            $('#city').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('')
                        }

                        if (error['state']) {
                            $('#state').addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(error['state'])
                        } else {
                            $('#state').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('')
                        }

                        if (error['zip']) {
                            $('#zip').addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .html(error['zip'])
                        } else {
                            $('#zip').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('')
                        }

                        if (error['mobile']) {
                            $('#mobile').addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(error['mobile'])
                        } else {
                            $('#mobile').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('')
                        }



                    }
                },
            })

        })


        $('#country').change(function() {

            $.ajax({
                url: ' {{ route('getOrderSummary') }} ',
                type: 'post',
                data: {
                    country_id: $(this).val()
                },
                dataType: 'json',
                success: function(response) {
                    $('#shipping').html('$' + response.ShippingCharges)
                    $('#grand-total').html('$' + response.GrandTotal)



                },
            })

        })

        $('#discount-button').click(function() {
            $(".loading-container").addClass("active")
            $.ajax({
                url: "{{ route('Get-Discount-Summary') }}",
                type: 'post',
                data: {
                    code: $('#discount-input').val(),
                    country_id: $('#country').val(),
                },
                dataType: 'json',
                success: function(response) {
                    $(".loading-container").removeClass("active")
                    if (response.status == true) {
                        const discountString = `<div class="mt-4 discount-code">
                            <strong>${response['coupon']}</strong>
                            <a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="removeCoupon()">X</a>
                        </div>`
                        $('#shipping').html('$' + response.ShippingCharges)
                        $('#discount').html('$' + response.discount)
                        $('#grand-total').html('$' + response.GrandTotal)
                        $('#discount-wrapper').html(response.discountString)
                        $('#coupon-error').html('')
                        $('#discount-input').val('')
                    } else {
                        $('#coupon-error').html(response.msg)
                    }
                },
            })
        })


        function removeCoupon() {
            $.ajax({
                url: ' {{ route('Remove-Coupon') }} ',
                type: 'post',
                data: {
                    country_id: $('#country').val(),
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == true) {
                        $('#shipping').html('$' + response.ShippingCharges)
                        $('#discount').html('$' + response.discount)
                        $('#grand-total').html('$' + response.GrandTotal)
                        $('.discount-code').html('')
                    }
                },
            })
        }
    </script>
    <!-- javascript link  -->
@endsection
