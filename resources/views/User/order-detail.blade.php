@extends('User.master')
@section('content')
<div class="order-button">
<a href="{{route('Order')}}" class="download-pdf-button gear-button">Back</a>
<a href="{{route('Download-Order-PDF',$order->id)}}" class="download-pdf-button gear-button">Download PDF</a>
</div>
<section class=" section-11 Order-detail-container">
    <div class="container ">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header nigth-card-header">
                        <h2 class=" mb-0 pt-2 pb-2 Order-detail-title nav-nigth">My Orders</h2>
                    </div>

                    <div class="card-body pb-0 ">
                        <!-- Info -->
                        <div class="card card-sm">
                            <div class="card-body  mb-3">
                                <div class="row">
                                    <div class="col-6 col-lg-3 order-detail-top">
                                        <!-- Heading -->
                                        <h6 class="nav-nigth">Order No:</h6>
                                        <!-- Text -->
                                        <p class="mb-lg-0 nav-nigth">
                                            {{ $order->id }}
                                        </p>
                                    </div>
                                    <div class="col-6 col-lg-3 order-detail-top">
                                        <!-- Heading -->
                                        <h6 class="nav-nigth">Shipped date:</h6>
                                        <!-- Text -->
                                        <p class="mb-lg-0 nav-nigth">
                                            <time datetime="2019-10-01" class="nav-nigth">

                                                @if(!empty($order->shipping_date))
                                                {{ \Carbon\Carbon::parse($order->shipping_date)->format('d M, Y') }}
                                                @else
                                                n/a
                                                @endif
                                            </time>
                                        </p>
                                    </div>
                                    <div class="col-6 col-lg-3 order-detail-top">
                                        <!-- Heading -->
                                        <h6 class="nav-nigth">Status:</h6>
                                        <!-- Text -->
                                        <p class="mb-0">
                                            @if($order->delivery_status == 'pending')
                                            <span class="badge bg-danger">Pending</span>
                                            @elseif($order->delivery_status == 'shipped')
                                            <span class="badge bg-info">Shipped</span>
                                            @elseif($order->delivery_status == 'delivered')
                                            <span class="badge bg-success">Delivered</span>
                                            @else
                                            <span class="badge bg-danger">Cancelled</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-6 col-lg-3 order-detail-top">
                                        <!-- Heading -->
                                        <h6 class="nav-nigth">Order Amount:</h6>
                                        <!-- Text -->
                                        <p class="mb-0 nav-nigth">
                                            ${{ number_format($order->grand_total,2) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer p-3">

                        <!-- Heading -->
                        <h6 class="mb-7 order-main-title mt-4 nav-nigth">Order Items ({{$orderCounts}})</h6>

                        <!-- Divider -->
                        <hr class="my-3">

                        <!-- List group -->
                        <ul>
                            @if(!empty($orderItems))
                            @foreach($orderItems as $orderItem)

                            @php
                            $img = ProductImage($orderItem->product_id) ;


                            @endphp
                            <li class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-4 col-md-3 col-xl-2">
                                        <!-- Image -->
                                        @if(!empty($img))
                                        <a href="product.html"><img
                                                src="{{asset('uploads/product/small/'.$img->image)}}" alt="..."
                                                class="img-fluid order-img">
                                        </a>

                                        @endif
                                    </div>
                                    <div class="col">
                                        <!-- Title -->
                                        <p class="mb-4 fs-sm fw-bold order-text">
                                            <a class="text-body nav-nigth" href="product.html">{{$orderItem->name}} x
                                                {{$orderItem->qty}}</a>
                                            <br>
                                            <span
                                                class="text-muted nav-nigth">${{number_format($orderItem->total,2)}}</span>
                                        </p>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="card card-lg  mt-3">
                    <div class="card-body">
                        <!-- Heading -->
                        <h6 class="mt-0 mb-3 order-main-title nav-nigth">Order Total</h6>

                        <!-- List group -->
                        <ul>
                            <li class="list-group-item d-flex order-sub-title">
                                <span class="nav-nigth">Subtotal</span>
                                <span class="ms-auto nav-nigth">${{ number_format($order->subtotal,2) }}</span>
                            </li>
                            <li class="list-group-item d-flex order-sub-title">
                                <span class="nav-nigth">Discount
                                    {{ ($order->coupon_code != null) ? '('.$order->coupon_code.')' : ''}}</span>
                                <span class="ms-auto nav-nigth">${{ number_format($order->discount,2) }}</span>
                            </li>
                            <li class="list-group-item d-flex order-sub-title">
                                <span class="nav-nigth">Shipping</span>
                                <span class="ms-auto nav-nigth">${{ number_format($order->shipping,2) }}</span>
                            </li>
                            <li class="list-group-item d-flex order-sub-title fs-lg fw-bold">
                                <span class="nav-nigth">Total</span>
                                <span class="ms-auto nav-nigth">${{ number_format($order->grand_total,2) }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@if($order->delivery_status == 'pending')

<div class="cancel-button">
<a href="javascript:void(0)" onclick="CancelOrder('{{ $order->id }}')" class="download-cancel-button">Cancel Order</a>
</div>
@endif

@if($order->delivery_status == 'delivered')

<div class="exchange-button-container">
<a href="{{ route('Exchange-order',$order->id) }}"  class="exchange-button">Exchange</a>
</div>
@endif
@endsection

@section('js')

<script>
function CancelOrder(id) {
    var url = '{{route("order-cancel","ID")}}';
    var newurl = url.replace('ID', id)
    if (confirm('Are You sure want to cancel order')) {
        $.ajax({
            url: newurl,
            type: 'get',
            data: {},
            dataType: 'json',
            success: function(response) {
                if (response['status']) {
                    window.location.href = '{{route("Order")}}'

                } else {
                    window.location.href = '{{route("Order")}}'
                }
            }
        })
    }


}
</script>
@endsection