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
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                        <option value="rest_of_world">Rest of World</option>
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <input type="text" name="amount" id="amount" class="form-control"
                                        placeholder="Amount">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Country</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($shippings))
                                @foreach( $shippings as $shipping)
                                <tr>
                                    <td>{{ $shipping->id }}</td>
                                    <td>{{ ( $shipping->country_id  == 'rest_of_world') ? 'Rest Of World' :  $shipping->name }}
                                    </td>
                                    <td>${{ $shipping->amount }}</td>
                                    <td>
                                        <a href=" {{ route('Edit-Shipping',$shipping->id) }}">
                                            <svg class="filament-link-icon w-4 h-4 mr-1"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a href="javascript:void(0)" onclick="deleteShipping( '{{ $shipping->id }}' )"
                                            class="text-danger w-4 h-4 mr-1">
                                            <svg wire:loading.remove.delay="" wire:target=""
                                                class="filament-link-icon w-4 h-4 mr-1"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" aria-hidden="true">
                                                <path ath fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
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
    $(".loading-container").addClass("active")

    $.ajax({
        url: '{{route("Store-shipping")}}',
        type: 'post',
        data: element.serializeArray(),
        dataType: 'json',
        success: function(response) {
            $('button[type=submit]').prop('disabled', false)
            $(".loading-container").removeClass("active")

            if (response['status'] == true) {
                window.location.href = '{{ route("Shipping") }}'

            } else {
                var error = response['errors']
                if (error['country_id']) {
                    $('#country_id').addClass('is-invalid').siblings('p').addClass(
                            'invalid-feedback')
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

function deleteShipping(id) {


    if (confirm('Are you want to delete')) {
        var url = '{{route("Delete-Shipping","ID")}}';
        var newurl = url.replace('ID', id)

        $.ajax({
            url: newurl,
            type: 'delete',
            data: {},
            dataType: 'json',
            success: function(response) {
                window.location.href = '{{ route("Shipping") }}'

            }
        })
    }
}
</script>
@endsection