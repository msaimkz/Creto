@extends('Admin.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('asset/admin/css/datetimepicker.css') }}">
@endsection
@section('content')
    <div class="content-wrapper">
        @include('Admin.message')
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Order: #{{ $order->id }}</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('order') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header pt-3">
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                        @php
                                            $country = country($order->country_id);

                                        @endphp
                                        <h1 class="h5 mb-3">Shipping Address</h1>
                                        <address>
                                            <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                                            {{ $order->address }}<br>{{ $order->city }}
                                            {{ $order->state }}, {{ $order->zip }} {{ $country->name }} <br>
                                            Phone: {{ $order->mobile }}<br>
                                            Email: {{ $order->email }}
                                        </address>
                                        <h1 class="h5" id="order-date-head">Shipping Date</h1>
                                        <address id="order-date">


                                            @if (!empty($order->shipping_date))
                                                {{ \Carbon\Carbon::parse($order->shipping_date)->format('d M, Y') }}
                                            @else
                                                n/a
                                            @endif
                                            <br>
                                        </address>
                                    </div>




                                    <div class="col-sm-4 invoice-col">
                                        <b>Invoice #{{ $order->id }}</b><br>
                                        <br>
                                        <b>Order ID:</b> {{ $order->id }}<br>
                                        <b>Total:</b> ${{ number_format($order->grand_total, 2) }}<br>
                                        <b>Status:</b>
                                        @if ($order->delivery_status == 'pending')
                                            <span id="delivery-text" class="text-danger">Pending</span>
                                        @elseif($order->delivery_status == 'shipped')
                                            <span id="delivery-text" class="text-info">Shipped</span>
                                        @elseif($order->delivery_status == 'delivered')
                                            <span id="delivery-text" class="text-success">Delivered</span>
                                        @else
                                            <span id="delivery-text" class="text-danger">Cancelled</span>
                                        @endif
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table-responsive p-3">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th width="100">Price</th>
                                            <th width="100">Qty</th>
                                            <th width="100">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($items as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>${{ number_format($item->price, 2) }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>${{ number_format($item->total, 2) }}</td>
                                            </tr>
                                        @endforeach

                                        <tr>
                                            <th colspan="3" class="text-right">Subtotal:</th>
                                            <td>${{ number_format($order->subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-right">Discount
                                                {{ $order->coupon_code != null ? '(' . $order->coupon_code . ')' : '' }}:
                                            </th>
                                            <td>${{ number_format($order->discount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-right">Shipping:</th>
                                            <td>${{ number_format($order->shipping, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-right">Grand Total:</th>
                                            <td>${{ number_format($order->grand_total, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <form method="post" id="StatusForm" name="StatusForm">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Order Status</h2>
                                    <div class="mb-3">
                                        <select name="status" id="status" class="form-control">
                                            <option value="pending"
                                                {{ $order->delivery_status == 'pending' ? 'selected' : ' ' }}>Pending
                                            </option>
                                            <option value="shipped"
                                                {{ $order->delivery_status == 'shipped' ? 'selected' : ' ' }}>Shipped
                                            </option>
                                            <option value="delivered"
                                                {{ $order->delivery_status == 'delivered' ? 'selected' : ' ' }}>Delivered
                                            </option>
                                            <option value="cancelled"
                                                {{ $order->delivery_status == 'cancelled' ? 'selected' : ' ' }}>Cancelled
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="shipping_date">Date</label>
                                        <input type="text" class="form-control" autocomplete="off" name="shipping_date"
                                            id="shipping_date"
                                            value="{{ $order->shipping_date ? $order->shipping_date : '' }}">
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form action="" method="post" id="InvoiceEmailSendForm" name="InvoiceEmailSendForm">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Send Inovice Email</h2>
                                    <div class="mb-3">
                                        <select name="userType" id="userType" class="form-control">
                                            <option value="customer">Customer</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary" type="submit">Send</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('js')
    <script src="{{ asset('asset/admin/js/datetimepicker.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#shipping_date').datetimepicker({
                // options here
                format: 'Y-m-d H:i:s',
            });

        });
        $('#StatusForm').submit(function(event) {
            event.preventDefault();
            $(".loading-container").addClass("active")

            if (confirm("Are you want to Sure Change Order Status")) {
                $.ajax({
                    url: '{{ route('Change-Status', $order->id) }}',
                    type: 'post',
                    data: $(this).serializeArray(),
                    dataType: 'json',
                    success: function(response) {
                        $(".loading-container").removeClass("active")
                        if (response["status"] == true) {


                            if (response["orderStatus"] == "cancelled") {
                                $("#delivery-text").removeClass().addClass("text-success").html(
                                    "Cancelled")
                                $("#order-date-head").html("Cancelled Date")
                                $("#order-date").html(response['date'])

                            } else if (response["orderStatus"] == "shipped") {
                                $("#delivery-text").removeClass().addClass("text-info").html("Shipped")
                                $("#order-date-head").html("Shipping Date")
                                $("#order-date").html(response['date'])
                            } else if (response["orderStatus"] == "delivered") {
                                $("#delivery-text").removeClass().addClass("text-success").html(
                                    "Deliverd")
                                $("#order-date-head").html("Deliverd Date")
                                $("#order-date").html(response['date'])
                            } else {
                                $("#delivery-text").removeClass().addClass("text-danger").html(
                                    "Pending")
                                $("#order-date-head").html("")
                                $("#order-date").html("")
                            }

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
                                title: response['msg']
                            });

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
                                title: response['errors']['shipping_date']
                            });

                        }

                    }


                })
            }
        })
        $('#InvoiceEmailSendForm').submit(function(event) {
            event.preventDefault();
            $(".loading-container").addClass("active")

            if (confirm("Are you want to Sure Send Order Email")) {
                $.ajax({
                    url: '{{ route('Send-Invioce-Email', $order->id) }}',
                    type: 'post',
                    data: $(this).serializeArray(),
                    dataType: 'json',
                    success: function(response) {
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

                    }


                })
            }
        })
    </script>
@endsection
