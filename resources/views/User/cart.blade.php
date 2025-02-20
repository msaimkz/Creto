@extends('User.master')
@section('content')


    <div class="cart-main-container">
        <div class="row cart-row">
            @if (Cart::count() > 0)
                <div class="col-md-8" id="cart-items">
                    <div class="table-responsive">
                        <table class="table" id="cart">
                            <thead class="cart-thead cart-header">
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody class="cart-tbody">
                                @foreach ($cartItems as $cartItem)
                                    <tr id="cart-row-{{ $cartItem->rowId }}">
                                        <td>
                                            <div class="d-flex align-items-center justify-content-start">
                                                @if (!empty($cartItem->options->productImage->image))
                                                    <img src="{{ asset('uploads/product/small/' . $cartItem->options->productImage->image) }}"
                                                        width="60px">
                                                @else
                                                    <img src="{{ asset('asset/img/default.avif') }}" width="60px">
                                                @endif
                                                <h2 class="nav-nigth">{{ $cartItem->name }}</h2>
                                            </div>
                                        </td>
                                        <td class="nav-nigth">${{ $cartItem->price }}</td>
                                        <td>
                                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-minus p-2 pt-1 pb-1 sub gear-button"
                                                        data-id="{{ $cartItem->rowId }}">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input readonly type="text" name="cartqty" id="cartqty"
                                                    class="form-control form-control-sm  border-0 text-center"
                                                    value="{{ $cartItem->qty }}">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-plus p-2 pt-1 pb-1 add gear-button"
                                                        data-id="{{ $cartItem->rowId }}">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="nav-nigth" id="price-{{ $cartItem->rowId }}">
                                            ${{ $cartItem->price * $cartItem->qty }}
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-danger"
                                                onclick="DeleteCart('{{ $cartItem->rowId }}')"><i
                                                    class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4 nigth-card" id="cart-price">
                    <div class="card cart-summery pt-2">
                        <div class="sub-title">
                            <h2 class="nav-nigth">Cart Summery</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between pb-2  cart-summary">
                                <div class="nav-nigth">Subtotal</div>
                                <div class="nav-nigth" id="subTotal">${{ Cart::subtotal() }}</div>
                            </div>
                            <div class="d-flex justify-content-between summery-end cart-summary">
                                <div class="nav-nigth">Total</div>
                                <div class="nav-nigth" id="total">${{ Cart::subtotal() }}</div>
                            </div>
                            <div class="pt-5 proceed-button">
                                <a href="{{ route('Checkout') }}" class="gear-button">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="cart-empty">Your Cart Is Empty</h1>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
@section('js')
    <!-- javascript link  -->


    <script type="text/javascript">
        $('.add').click(function() {
            var qtyElement = $(this).parent().prev();
            var qtyValue = parseInt(qtyElement.val());
            if (qtyValue < 100) {
                qtyElement.val(qtyValue + 1);
                var rowid = $(this).data("id")
                var qty = qtyElement.val();
                UpdateCart(rowid, qty)
            }
        });

        $('.sub').click(function() {
            var qtyElement = $(this).parent().next();
            var qtyValue = parseInt(qtyElement.val());
            if (qtyValue > 1) {
                qtyElement.val(qtyValue - 1);
                var rowid = $(this).data("id")
                var qty = qtyElement.val();
                UpdateCart(rowid, qty)
            }
        });


        function UpdateCart(rowid, qty) {
            $(".loading-container").addClass("active")

            $.ajax({
                url: "{{ route('Update-Cart') }}",
                type: 'post',
                data: {
                    rowid: rowid,
                    qty: qty,
                },
                dataType: 'json',
                success: function(response) {
                    $(`#price-${response['id']}`).html(`$${response['price']}`)
                    $("#subTotal").html(`$${response['totalPrice']}`)
                    $("#total").html(`$${response['totalPrice']}`)
                    $(".loading-container").removeClass("active")
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
                },

            })


        }

        $('#cartqty').change(function() {

            var ProductId = $('.add').data("id")
            var Productqty = $('#cartqty').val()
            $(".loading-container").addClass("active")
            $.ajax({
                url: "{{ route('Check-Cart') }}",
                type: 'post',
                data: {
                    rowid: ProductId,
                    qty: Productqty,
                },
                dataType: 'json',
                success: function(response) {


                    $(`#price-${response['id']}`).removeClass("active")
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
                    (response['price']) && $("#price").html(`$${response['price']}`)
                        (response['totalPrice']) && $("#subTotal").html(`$${response['totalPrice']}`)
                        (response['totalPrice']) && $("#total").html(`$${response['totalPrice']}`)

                },
            })

        })

        function DeleteCart(rowid) {
            if (confirm("Are You Want to Delete")) {
                $(".loading-container").addClass("active")
                $.ajax({
                    url: "{{ route('Delete-Cart') }}",
                    type: 'post',
                    data: {
                        rowid: rowid,
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response['cartCount'] == 0) {
                            const clutter = `<div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h1 class="cart-empty">Your Cart Is Empty</h1>
                                                    </div>
                                                </div>
                                            </div>`
                            $(".cart-row").html(clutter)
                        }
                        $(".loading-container").removeClass("active")
                        $(`#cart-row-${response['id']}`).remove()
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
                    },

                })

            }

        }
    </script>
    <!-- javascript link  -->
@endsection
