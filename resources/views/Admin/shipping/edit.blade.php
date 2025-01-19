@extends("Admin.master")
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    @include('Admin.message')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Shipping Management</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="" method="post" id="ShippingForm" name="ShippingForm">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <select name="country_id" id="country_id" class="form-control">
                                        <option value="">Select a Country</option>
                                        @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ ($shipping->country_id == $country->id) ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                        <option value="rest_of_world" {{ ($shipping->country_id == 'rest_of_world') ? 'selected' : '' }}>Rest of World</option>
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <input type="text" name="amount" id="amount" class="form-control" value="{{$shipping->amount}}"
                                        placeholder="Amount">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{route('Shipping')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <!-- /.content -->
</div>
@endsection

@section('js')
<script>
    $('#ShippingForm').submit(function(event) {
        event.preventDefault();
        var element = $(this)
        $('button[type=submit]').prop('disabled', true)
        $.ajax({
            url: '{{route("Update-Shipping",$shipping->id)}}',
            type: 'post',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response) {
                $('button[type=submit]').prop('disabled', false)
                if (response['status'] == true) {
                    window.location.href = '{{ route("Shipping") }}'

                } else {
                    var error = response['errors']
                    if (error['country_id']) {
                        $('#country_id').addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                            .html(error['country_id'])
                    } else {
                        $('#name').removeClass('is-invalid').siblings('p').removeClass(
                            'invalid-feedback').html('')
                    }

                    if (error['amount']) {
                        $('#amount').addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                            .html(error['amount'])
                    } else {
                        $('#amount').removeClass('is-invalid').siblings('p').removeClass(
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