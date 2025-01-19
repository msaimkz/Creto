@extends('User.master')

@section('css')

<link rel="stylesheet" href="{{asset('asset/admin/plugins/dropzone/dropzone.css')}}">


@endsection
@section('content')

<section class="section-9 pt-4">
    <div class="container">
        <form action="" method="post" id="OrderForm" name="OrderForm">
            <div class="row" id="checkout-row">
                <div class="col-md-8" id="checkout-col-1">
                    <div class="sub-title">
                        <h2 id="checkout-title" class="nav-nigth">Exchange Order</h2>
                    </div>
                    <div class="card  border-0">
                        <div class="card-body checkout-form">
                            <div class="row checkout-input-container">
                                <div class="input-main-container">
                                    <h2>Order Information</h2>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="orderid" class="input-label">Order Id</label>
                                                <input type="text" name="orderid" id="orderid" class="form-control"
                                                    readonly placeholder="Order Id" value="{{ $order->id }}">
                                                <p></p>
                                            </div>
                                        </div>
                                        @if($order->coupon_code != null)
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="couponcode" class="input-label">Coupon Code</label>
                                                <input type="text" name="couponcode" id="couponcode"
                                                    class="form-control" readonly placeholder="Coupon Code"
                                                    value="{{ $order->coupon_code }}">
                                                <p></p>
                                            </div>
                                        </div>
                                        @endif

                                    </div>

                                </div>
                                <div class="input-main-container mt-4">
                                    <h2>Customer Detail</h2>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="name" class="input-label">Name</label>
                                                <input type="text" name="name" id="name" class="form-control"
                                                    placeholder="Name" value="">
                                                <p></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="email" class="input-label">Email</label>
                                                <input type="email" name="email" id="email" class="form-control"
                                                    placeholder="Email" value="">
                                                <p></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="mobile" class="input-label">Mobile No</label>
                                                <input type="mobile" name="mobile" id="mobile" class="form-control"
                                                    placeholder="Mobile No" value="">
                                                <p></p>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="input-main-container">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="country" class="input-label">Country</label>
                                                <select name="country" id="country" class="form-control">
                                                    <option value="">Select a Country</option>
                                                    @foreach($countries as $country)
                                                    <option value="{{$country->id}}">
                                                        {{$country->name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <p></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="city" class="input-label">City</label>
                                                <input type="city" name="city" id="city" class="form-control"
                                                    placeholder="City" value="">
                                                <p></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="state" class="input-label">State</label>
                                                <input type="state" name="state" id="state" class="form-control"
                                                    placeholder="State" value="">
                                                <p></p>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="input-main-container">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div>
                                                <label for="Recivingaddress" class="input-label">Reciving
                                                    Address</label>
                                                <textarea name="Recivingaddress" id="Recivingaddress" cols="30" rows="4"
                                                    placeholder="Reciving Address" class="form-control"></textarea>
                                                <p></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="shippingaddress" class="input-label">Shipping
                                                    Address</label>
                                                <textarea name="shippingaddress" id="shippingaddress" cols="30" rows="4"
                                                    placeholder="Shipping Address" class="form-control"></textarea>
                                                <p></p>
                                            </div>
                                        </div>


                                    </div>

                                </div>
                                <div class="input-main-container mt-4">
                                    <h2>Order Products</h2>
                                    <div class="input-checkbox-container">
                                        @foreach($orderItems as $item)
                                        <div class="input-checkbox-parent">
                                            <div>
                                                <div class="input-check-box">
                                                    <input type="checkbox" name="orderproducts[]" class="orderproducts"
                                                        value="{{ $item->product_id }}">
                                                    <label class="input-label"
                                                        for="orderproducts">{{ $item->name }}</label>
                                                </div>

                                                <p></p>
                                            </div>
                                        </div>

                                        @endforeach


                                    </div>

                                </div>
                                <div class="Product-Container">
                                </div>


                            </div>
                        </div>
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


<script type="text/javascript">
$('.orderproducts').change(function() {

    products()

})

$(document).on('change', '.exchangeproduct', function() {

    $.ajax({
        url: '{{ route("get-exchange-product") }}',
        type: 'post',
        data: {
            product_id: $(this).val(),
            item_id:$(this).data('id')
        },
        dataType:'json',
        success:function(response){

           
            $('#qty').val(response.qty);
            $('#total-'+response.itemId).html('$' + response.total);
            $('#price-'+response.itemId).html('$' + response.price);

        }
    })

});


function products() {
    var productsID = [];

    $('.orderproducts').each(function() {
        if ($(this).is(':checked') == true) {
            productsID.push($(this).val())

        }
    })

    $.ajax({
        url: '{{ route("get-products") }}',
        type: 'post',
        data: {
            product_id: productsID,
            orderID: $('#orderid').val(),
        },
        dataType: 'json',
        success: function(response) {

            if (response.status == true) {
                var items = response.products;
                var clutter = "";

                items.forEach(function(item) {

                    clutter += `
                     <div class="input-main-container">
                                        <h3>${item.name}</h3>
                                        <div class="row">
                                            <div class="col-md-3 order-field">
                                                <div>
                                                    <label class="input-product-label">Product</label>
                                                    <h3 class="input-title">${item.name}</h3>
                                                </div>
                                            </div>
                                            <div class="col-md-3 order-field">
                                                <div>
                                                    <label class="input-product-label">Product
                                                        Price</label>
                                                    <h3 class="input-title">
                                                      $${parseFloat(item.price).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                                                    </h3>

                                                </div>
                                            </div>
                                            <div class="col-md-3 order-field">
                                                <div id="input-contain">
                                                    <label class="input-product-label">Product
                                                        Quantity</label>
                                                    <h3 class="input-title">${item.qty}</h3>

                                                </div>
                                            </div>
                                            <div class="col-md-3 order-field">
                                                <div id="input-contain">
                                                    <label class="input-product-label">Total
                                                        Price</label>
                                                    <h3 class="input-title">
                                                       $${parseFloat(item.total).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                                                    </h3>

                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="input-main-container">
                                        <h3>Exchange Product</h3>
                                        <div class="row Product-row">
                                            <div class="col-md-3">
                                                <div>
                                                    <label for="exchangeproduct" class="input-product-label">
                                                        Product
                                                    </label>
                                                    <select name="exchangeproduct"  id="exchangeproduct"
                                                        class="form-control exchangeproduct" data-id="${item.product_id}">
                                                        <option value="">Select a Product</option>
                                                        @foreach($products as $product)
                                                        <option value="{{$product->id}}">
                                                            {{$product->title}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    <p></p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div>
                                                    <label for="exchangeproductprice" class="input-product-label">
                                                        Product Price
                                                    </label>
                                                    <h3 class="input-title exchangeproductprice" id="price-${item.product_id}">$00.00</h3>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div>
                                                    <label for="exchangeproductqty" class="input-product-label">
                                                        Product Quantity
                                                    </label>
                                                    <div class="input-group quantity" style="width: 100px;">
                                                        <div class="input-group-btn">
                                                            <button type="button"
                                                                class="btn btn-sm btn-minus p-2   gear-button sub "
                                                                data-id="">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </div>
                                                        <input type="text" readonly name="qty" id="qty"
                                                            class="form-control form-control-sm  border-0 text-center"
                                                            value="1">
                                                        <div class="input-group-btn">
                                                            <button type="button"
                                                                class="btn btn-sm btn-plus p-2 add gear-button"
                                                                data-id="">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div>
                                                    <label for="exchangetotalprice" class="input-product-label">
                                                        Total Price
                                                    </label>

                                                    <h3 class="input-title exchangetotalprice" id="total-${item.product_id}">$00.00</h3>

                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="input-main-container">
                                        <h3>Reason For Exchange</h3>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div>
                                                    <label for="reason" class="input-label">
                                                        Reason
                                                    </label>
                                                    <textarea name="reason" id="reason" cols="30" rows="4"
                                                        placeholder="Reason For Exchange"
                                                        class="form-control"></textarea>
                                                    <p></p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div>
                                                    <label for="shippingaddress" class="input-label">
                                                        Media Files
                                                    </label>
                                                    <div class="card mb-3">
                                                        <div class="card-body">
                                                            <div id="image" class="dropzone dz-clickable">
                                                                <div class="dz-message needsclick">
                                                                    <br>Drop files here or click to upload.<br><br>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
             `

                })

                $('.Product-Container').html(clutter)
            } else {
                $('.Product-Container').html("")

            }


        }
    })
}
</script>

@endsection