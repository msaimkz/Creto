@extends("Admin.master")
@section('css')
<link rel="stylesheet" href="{{asset('asset/admin/plugins/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="{{asset('asset/admin/plugins/dropzone/dropzone.css')}}">
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit News</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('news')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="" method="post" id="Newsform" name="Newsform">
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title">Title</label>
                                            <input type="text" name="title" id="title" class="form-control"
                                                placeholder="Title" value="{{$news->title}}">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="slug">Slug</label>
                                            <input type="text" readonly name="slug" id="slug" class="form-control"
                                                placeholder="slug" value="{{$news->slug}}">
                                            <p class="error"></p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="writer">writer</label>
                                                <input type="text" name="writer" id="writer" class="form-control"
                                                    placeholder="writer" value="{{$news->writer}}">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="10"
                                                class="summernote"
                                                placeholder="Description">{{$news->descripion}}</textarea>
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="short_description">Short Description</label>
                                            <textarea name="short_description" id="short_description" cols="30"
                                                rows="10" class="summernote"
                                                placeholder="short_description">{{$news->short_descripion}}</textarea>
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                            <input type="hidden" id="newsimage" name="newsimage">
                                <h2 class="h4 mb-3">Media</h2>
                                <div id="image" class="dropzone dz-clickable">
                                    <div class="dz-message needsclick">
                                        <br>Drop files here or click to upload.<br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(!empty($news->img))
                        <div class="col-md-3">
                            <div class="card">
                                <input type="hidden" name="img_array" value="{{$news->id}}">
                                <img src="{{asset('uploads/News/thumb/small/'.$news->img)}}" class="card-img-top"
                                    alt="...">
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Blog status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{($news->status) == 1 ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{($news->status) == 0 ? 'selected' : ''}}>Block</option>
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Home News</h2>
                                <div class="mb-3">
                                    <select name="is_Home" id="is_Home" class="form-control">
                                        <option value="No" {{($news->is_Home) == 'No' ? 'selected' : ''}}>No</option>
                                        <option value="Yes" {{($news->is_Home) == 'Yes' ? 'selected' : ''}}>Yes</option>
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{route('news')}}" class="btn btn-outline-dark ml-3">Cancel</a>
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
<script src="{{asset('asset/admin/plugins/summernote/summernote.min.js')}}"></script>
<script src="{{asset('asset/admin/plugins/dropzone/dropzone.js')}}"></script>
<script>
$(document).ready(function() {
    $('.summernote').summernote({
        height: 250,
    })
})

Dropzone.autoDiscover = false;
const dropzone = $("#image").dropzone({
    init: function() {
        this.on('addedfile', function(file) {
            if (this.files.length > 1) {
                this.removeFile(this.files[0]);
            }
        });
    },
    url: "{{route('Temp-image')}}",
    maxFiles: 1,
    paramName: 'image',
    addRemoveLinks: true,
    acceptedFiles: "image/jpeg,image/png,image/gif,image/webp",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(file, response) {
        $("#newsimage").val(response.Image_id);
        //console.log(response)
    }
});



$('#Newsform').submit(function(event) {
    event.preventDefault();
    var element = $(this)
    $('button[type=submit]').prop('disabled', true)
    $.ajax({
        url: '{{route("Update-News",$news->id)}}',
        type: 'post',
        data: element.serializeArray(),
        dataType: 'json',
        success: function(response) {
            $('button[type=submit]').prop('disabled', false)
            if (response['status'] == true) {
                $('.error').removeClass('invalid-feedback').html('')
                $('input,select,textarea').removeClass('is-invalid')
                window.location.href = '{{route("news")}}'

            } else {
                var error = response['errors']
                $('.error').removeClass('invalid-feedback').html('')
                $('input,select,textarea').removeClass('is-invalid')
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

$('#title').change(function() {
    var element = $(this).val();
    $('button[type=submit]').prop('disabled', true)
    $.ajax({
        url: '{{route("GetSlug")}}',
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