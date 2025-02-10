@extends("Admin.master")
@section('css')
<link rel="stylesheet" href="{{asset('asset/admin/plugins/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="{{asset('asset/admin/plugins/dropzone/dropzone.css')}}">
<link rel="stylesheet" href="{{asset('asset/admin/plugins/select2/css/select2.min.css')}}">

@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('product')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form action="" method="post" id="productform" name="productform">
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
                                                placeholder="Title">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="slug">Slug</label>
                                            <input type="text" readonly name="slug" id="slug" class="form-control"
                                                placeholder="slug">
                                            <p class="error"></p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="model">Model</label>
                                                <input type="text" name="model" id="model" class="form-control"
                                                    placeholder="model">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                                <textarea name="description" id="description" cols="30" rows="10"
                                                class="summernote" placeholder="Description"></textarea>
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="shipping">Shipping</label>
                                            <textarea name="shipping" id="shipping" cols="30" rows="10"
                                                class="summernote" placeholder="shipping"></textarea>
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Media</h2>
                                <div id="image" class="dropzone dz-clickable">
                                    <div class="dz-message needsclick">
                                        <br>Drop files here or click to upload.<br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="tempimage">

                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Pricing</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="price">Price</label>
                                            <input type="number" name="price" id="price" class="form-control"
                                                placeholder="Price">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Inventory</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku">SKU (Stock Keeping Unit)</label>
                                            <input type="text" name="sku" id="sku" class="form-control"
                                                placeholder="sku">
                                            <p class="error"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="qty">Quantity</label>
                                            <input type="number" name="qty" id="qty" class="form-control"
                                                placeholder="qty">
                                            <p class="error"></p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Related Product</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <select multiple name="related_product[]" id="related_product"
                                                class="form-control w-100">
                                            </select>
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
                                <h2 class="h4 mb-3">Product status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h2 class="h4  mb-3">Product category</h2>
                                <div class="mb-3">
                                    <label for="category_id">Category</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option value="">Select A Category</option>
                                        @if($categories->isNotEmpty())
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product brand</h2>
                                <div class="mb-3">
                                    <select name="brand_id" id="brand_id" class="form-control">
                                        <option value="">Select a Brand</option>
                                        @if($brands->isNotEmpty())
                                        @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Featured product</h2>
                                <div class="mb-3">
                                    <select name="is_featured" id="is_featured" class="form-control">
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Gender</h2>
                                <div class="mb-3">
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="">Select A Gender</option>
                                        <option value="men">Men</option>
                                        <option value="women">Women</option>
                                        <option value="kid">kid</option>
                                    </select>
                                    <p class="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{route('product')}}" class="btn btn-outline-dark ml-3">Cancel</a>
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
<script src="{{asset('asset/admin/plugins/select2/js/select2.min.js')}}"></script>

<script>
    $('#related_product').select2({
    ajax: {
        url: '{{ route("get-product") }}',
        dataType: 'json',
        tags: true,
        multiple: true,
        minimumInputLength: 3,
        processResults: function (data) {
            return {
                results: data.tags
            };
        }
    }
}); 
$(document).ready(function() {
    $('.summernote').summernote({
        height: 250,
    })
})

Dropzone.autoDiscover = false;
const dropzone = $("#image").dropzone({
    url: "{{route('Temp-image')}}",
    maxFiles: 10,
    paramName: 'image',
    addRemoveLinks: true,
    acceptedFiles: "image/jpeg,image/png,image/gif,image/webp",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function(file, response) {
        var html = `<div class="col-md-3" id="row-image-${response.Image_id}">
                    <div class="card">
                    <input type="hidden" name="img_array[]" value="${response.Image_id}">  
                    <img src="${response.Image_path}" class="card-img-top" alt="...">
                    <div class="card-body">
                    <a href="javascript:viod(0)" onclick = "deleteTempImg(${response.Image_id})" class="btn btn-danger">delete</a>
                    </div>
                    </div>
                </div>`

        $('#tempimage').append(html)
    },
    complete: function(file) {
        this.removeFile(file)
    }
});

function deleteTempImg(id) {
    $('#row-image-' + id).remove();
}



$('#productform').submit(function(event) {
    event.preventDefault();
    var element = $(this)
    $('button[type=submit]').prop('disabled', true)
    $.ajax({
        url: '{{route("Store-product")}}',
        type: 'post',
        data: element.serializeArray(),
        dataType: 'json',
        success: function(response) {
            $('button[type=submit]').prop('disabled', false)
            if (response['status'] == true) {
                $('.error').removeClass('invalid-feedback').html('')
                $('input,select,textarea').removeClass('is-invalid')
                window.location.href = '{{route("product")}}'
            } else {
                var error = response['errors']
                $('.error').removeClass('invalid-feedback').html('')
                $('input,select,textarea').removeClass('is-invalid')
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