
@extends('Admin.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
@include('Admin.message')
<section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Send Subscription</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('Subscribers')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="" method="post" id="SendSubscriptionForm" name="SendSubscriptionForm">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" readonly name="name" id="name" class="form-control" placeholder="Name" value="{{ $subscriber->name }}">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input type="text" readonly name="email" id="email" class="form-control" placeholder="Email" value="{{ $subscriber->email }}">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="coupon">Discout Coupon</label>
                                    <select name="coupon"  id="coupon" class="form-control">
                                        <option value="">Select a Coupon</option>
                                        @if(!empty($coupons))
                                        @foreach($coupons as $coupon)
                                        <option value="{{ $coupon->id }}">{{ $coupon->code }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary" id="button">Send</button>
                    <a href="{{route('Subscribers')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </div>
        </form>
        <!-- /.card -->
    </section>
</div>
<!-- /.content-wrapper -->
@endsection
@section('js')

<script>
$('#SendSubscriptionForm').submit(function(event){
event.preventDefault()
$('#button').prop('disabled',true)

$.ajax({
    url:'{{ route("Send-Subscriber")}}',
    type:'post',
    data: { 
        coupon : $('#coupon').val(),
        id: '{{$subscriber->id}}'

    },
    dataType:'json',
    success: function(response){
        $('#button').prop('disabled',false)


        if(response.status == true){

             
            $('#coupon').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')

            window.location.href = '{{ route("Show-Subscriber",$subscriber->id) }}'

        }
        else{
            var error = response['error']
            if(error['coupon']){

                $('#coupon').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error['coupon'])


            }
            else{
                $('#coupon').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')

            }

        }
    } 
})
})
</script>
@endsection