@extends("Admin.master")
@section('css')
<link rel="stylesheet" href="{{asset('asset/admin/css/datetimepicker.css')}}">
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Dicount Coupon</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('discount')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="" method="post" id="DiscountForm" name="DiscountForm">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code">Coupon Code</label>
                                    <input type="text" name="code" id="code" class="form-control"
                                        placeholder="Coupon Code" value="{{ $coupon->code }}">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Coupon Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Coupon Name"  value="{{ $coupon->name }}">

                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_uses">Max Uses</label>
                                    <input type="number" name="max_uses" id="max_uses" class="form-control"
                                        placeholder="Max Uses"  value="{{ $coupon->max_uses }}">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_user_uses">Max User Uses</label>
                                    <input type="number" name="max_user_uses" id="max_user_uses" class="form-control"
                                        placeholder="Max User Uses"  value="{{ $coupon->max_user_uses }}">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type">Type</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="fixed" {{ ($coupon->type == 'fixed') ? 'selected' : '' }}>Fixed</option>
                                        <option value="percent" {{ ($coupon->type == 'percent') ? 'selected' : '' }}>Percent</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ ($coupon->status == 1) ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ ($coupon->status == 0) ? 'selected' : '' }}>Block</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="discount_amount">Discount Amount</label>
                                    <input type="text" name="discount_amount" id="discount_amount" class="form-control"
                                        placeholder="Discount Amount"  value="{{ $coupon->discount_amount }}">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="min_amount">Minimum Amount</label>
                                    <input type="text" name="min_amount" id="min_amount" class="form-control"
                                        placeholder="Minimum Amount"  value="{{ $coupon->min_amount }}">

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_at">Start At</label>
                                    <input autocomplete="off" type="text" name="start_at" id="start_at" class="form-control"
                                        placeholder="Start At"  value="{{ $coupon->start_at }}">
                                        <p></p>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expire_at">Expire At</label>
                                    <input autocomplete="off" type="text" name="expire_at" id="expire_at" class="form-control"
                                        placeholder="Expire At"  value="{{ $coupon->expire_at }}">
                                        <p></p>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="description">Description</label>

                                <div class="mb-3">
                                    <textarea name="description" id="description" cols="60" rows="5"
                                        placeholder="Description">{{ $coupon->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{route('discount')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </div>
        </form>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection

@section('js')
<script src="{{asset('asset/admin/js/datetimepicker.js')}}"></script>
<script>
$(document).ready(function() {
    $('#start_at').datetimepicker({
        // options here
        format: 'Y-m-d H:i:s',
    });
    $('#expire_at').datetimepicker({
        // options here
        format: 'Y-m-d H:i:s',
    });
});
$('#DiscountForm').submit(function(event) {
    event.preventDefault();
    var element = $(this)
    $('button[type=submit]').prop('disabled', true)
    $.ajax({
        url: '{{route("Update-Dicount-Coupon",$coupon->id)}}',
        type: 'post',
        data: element.serializeArray(),
        dataType: 'json',
        success: function(response) {
            $('button[type=submit]').prop('disabled', false)
            if (response['status'] == true) {


                window.location.href = '{{route("discount")}}'
                $('#code').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback')
                    .html('')
                $('#discount_amount').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback')
                    .html('')

            } else {
                var error = response['errors']
                if (error['code']) {
                    $('#code').addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                        .html(error['code'])
                } else {
                    $('#code').removeClass('is-invalid').siblings('p').removeClass(
                        'invalid-feedback').html('')
                }

                if (error['discount_amount']) {
                    $('#discount_amount').addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                        .html(error['discount_amount'])
                } else {
                    $('#discount_amount').removeClass('is-invalid').siblings('p').removeClass(
                        'invalid-feedback').html('')
                }

                if (error['start_at']) {
                    $('#start_at').addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                        .html(error['start_at'])
                } else {
                    $('#start_at').removeClass('is-invalid').siblings('p').removeClass(
                        'invalid-feedback').html('')
                }

                if (error['expire_at']) {
                    $('#expire_at').addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                        .html(error['expire_at'])
                } else {
                    $('#expire_at').removeClass('is-invalid').siblings('p').removeClass(
                        'invalid-feedback').html('')
                }
            }
        },
        error: function(JQXHR, exception) {
            console.log('Something Error');
        }
    })

})
</script>
@endsection