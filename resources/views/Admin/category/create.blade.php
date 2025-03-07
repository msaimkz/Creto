@extends('Admin.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Category</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('category') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <form action="" method="post" id="CategoryForm" name="CategoryForm">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="Name">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="slug">Slug</label>
                                        <input type="text" readonly name="slug" id="slug" class="form-control"
                                            placeholder="Slug">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Block</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{ route('category') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                    </div>
                </div>
            </form>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('js')
    <script>
        $('#CategoryForm').submit(function(event) {
            event.preventDefault();
            var element = $(this)
            $('button[type=submit]').prop('disabled', true)
            $(".loading-container").addClass("active")

            $.ajax({
                url: '{{ route('Store-Category') }}',
                type: 'post',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $('button[type=submit]').prop('disabled', false)
                    $(".loading-container").removeClass("active")

                    if (response["status"] == true) {
                        window.location.href = '{{ route('category') }}'
                        $('#name').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('')
                        $('#slug').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback')
                            .html('')

                    } else {
                        var error = response['errors']
                        if (error['name']) {
                            $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .html(error['name'])
                        } else {
                            $('#name').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('')
                        }

                        if (error['slug']) {
                            $('#slug').addClass('is-invalid').siblings('p').addClass('invalid-feedback')
                                .html(error['slug'])
                        } else {
                            $('#slug').removeClass('is-invalid').siblings('p').removeClass(
                                'invalid-feedback').html('')
                        }
                    }
                },
                error: function(JQXHR, exception) {
                    console.log('Something Error');
                }
            })

        })

        $('#name').change(function() {
            var element = $(this).val();
            $('button[type=submit]').prop('disabled', true)
            $(".loading-container").addClass("active")

            $.ajax({
                url: '{{ route('GetSlug') }}',
                type: 'get',
                data: {
                    title: element
                },
                dataType: 'json',
                success: function(respose) {
                    $('button[type=submit]').prop('disabled', false)
                    $(".loading-container").removeClass("active")
                    $('#slug').val(respose['slug']);
                }
            })
        })
    </script>
@endsection
