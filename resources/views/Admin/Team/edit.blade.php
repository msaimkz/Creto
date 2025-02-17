@extends('Admin.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('asset/admin/plugins/dropzone/dropzone.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Member</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('Admin-team') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <form action="" method="post" id="teamForm" name="teamForm">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" id="name" class="form-control"
                                                    placeholder="name" value="{{ $member->name }}">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="slug">Slug</label>
                                                <input type="text" readonly name="slug" id="slug"
                                                    class="form-control" placeholder="slug" value="{{ $member->slug }}">
                                                <p class="error"></p>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="designation">Designation</label>
                                                    <input type="text" name="designation" id="designation"
                                                        class="form-control" placeholder="designation"
                                                        value="{{ $member->designation }}">
                                                    <p class="error"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <input type="hidden" id="teamimage" name="teamimage">
                                    <h2 class="h4 mb-3">Media</h2>
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (!empty($member->img))
                                <div class="col-md-3">
                                    <div class="card">
                                        <input type="hidden" name="img_array" value="{{ $member->id }}">
                                        <img src="{{ asset('uploads/team/thumb/' . $member->img) }}" class="card-img-top"
                                            alt="...">
                                    </div>
                                </div>
                            @endif
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Social Media Links</h2>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="price">Facebook</label>
                                                <input type="text" name="facebook" id="facebook" class="form-control"
                                                    placeholder="facebook" value="{{ $member->facebook_url }}">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="price">Youtube</label>
                                                <input type="text" name="youtube" id="youtube" class="form-control"
                                                    placeholder="youtube" value="{{ $member->youtube_url }}">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="price">Instagram</label>
                                                <input type="text" name="instagram" id="instagram" class="form-control"
                                                    placeholder="instagram" value="{{ $member->instagram_url }}">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="price">X-crop</label>
                                                <input type="text" name="X" id="X" class="form-control"
                                                    placeholder="X-crop" value="{{ $member->X_url }}">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Member status</h2>
                                    <div class="mb-3">
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" {{ $member->status == 1 ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ $member->status == 0 ? 'selected' : '' }}>Block
                                            </option>
                                        </select>
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{ route('Admin-team') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                    </div>
                </div>
            </form>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')
    <script src="{{ asset('asset/admin/plugins/dropzone/dropzone.js') }}"></script>


    <script>
        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
            },
            url: "{{ route('Temp-image') }}",
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif,image/webp",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                $("#teamimage").val(response.Image_id);
                //console.log(response)
            }
        });




        $('#teamForm').submit(function(event) {
            event.preventDefault();
            var element = $(this)
            $('button[type=submit]').prop('disabled', true)
            $(".loading-container").addClass("active")

            $.ajax({
                url: '{{ route('Update-member', $member->id) }}',
                type: 'post',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $('button[type=submit]').prop('disabled', false)
                    $(".loading-container").removeClass("active")


                    if (response['status'] == true) {
                        $('.error').removeClass('invalid-feedback').html('')
                        window.location.href = "{{ route('Admin-team') }}"


                    } else {
                        var error = response['errors']
                        $('.error').removeClass('invalid-feedback').html('')

                        console.log(error)
                        $.each(error, function(key, value) {
                            $(`#${key}`).addClass('is-invalid').siblings('p').addClass(
                                    'invalid-feedback')
                                .html(value)
                        })

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
            $.ajax({
                url: '{{ route('GetSlug') }}',
                type: 'get',
                data: {
                    title: element
                },
                dataType: 'json',
                success: function(respose) {
                    $('button[type=submit]').prop('disabled', false)
                    $('#slug').val(respose['slug']);
                }
            })
        })
    </script>
@endsection
