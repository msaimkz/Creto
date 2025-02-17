@extends('Admin.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('asset/admin/plugins/summernote/summernote.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/plugins/dropzone/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/plugins/select2/css/select2.min.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Product</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('product') }}" class="btn btn-primary">Back</a>
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
                                                    placeholder="Title" value="{{ $product->title }}">
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="slug">Slug</label>
                                                <input type="text" readonly name="slug" id="slug"
                                                    class="form-control" placeholder="slug" value="{{ $product->slug }}">
                                                <p class="error"></p>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="model">Model</label>
                                                    <input type="text" name="model" id="model" class="form-control"
                                                        placeholder="model" value="{{ $product->model }}">
                                                    <p class="error"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description" cols="30" rows="10" class="summernote"
                                                    placeholder="Description">{{ $product->description }}</textarea>
                                                <p class="error"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="shipping">Shipping</label>
                                                <textarea name="shipping" id="shipping" cols="30" rows="10" class="summernote" placeholder="shipping">{{ $product->shipping }}</textarea>
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
                                @if (!empty($Productimage))
                                    @foreach ($Productimage as $Image)
                                        <div class="col-md-3" id="row-image-{{ $Image->id }}">
                                            <div class="card">
                                                <input type="hidden" name="img_array[]" value="{{ $Image->id }}">
                                                <img src="{{ asset('uploads/product/small/' . $Image->image) }}"
                                                    class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <a href="javascript:void(0)"
                                                        onclick="deleteTempImg({{ $Image->id }})"
                                                        class="btn btn-danger">delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Pricing</h2>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="price">Price</label>
                                                <input type="number" name="price" id="price" class="form-control"
                                                    placeholder="Price" value="{{ $product->price }}">
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
                                                    placeholder="sku" value="{{ $product->sku }}">
                                                <p class="error"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="qty">Quantity</label>
                                                <input type="number" name="qty" id="qty" class="form-control"
                                                    placeholder="qty" value="{{ $product->qty }}">
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
                                                    @if (!empty($relatedProduct))
                                                        @foreach ($relatedProduct as $relatedProducts)
                                                            <option selected value="{{ $relatedProducts->id }}">
                                                                {{ $relatedProducts->title }}</option>
                                                        @endforeach
                                                    @endif
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
                                            <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Block
                                            </option>
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
                                            @if ($categories->isNotEmpty())
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}</option>
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
                                            @if ($brands->isNotEmpty())
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                        {{ $brand->name }}
                                                    </option>
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
                                            <option value="No"
                                                {{ $product->is_featured == 'No' ? 'selected' : '' }}>No
                                            </option>
                                            <option value="Yes"
                                                {{ $product->is_featured == 'Yes' ? 'selected' : '' }}>Yes
                                            </option>
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
                                            <option value="men" {{ $product->gender == 'men' ? 'selected' : '' }}>Men
                                            </option>
                                            <option value="women" {{ $product->gender == 'women' ? 'selected' : '' }}>
                                                Women
                                            </option>
                                            <option value="kid" {{ $product->gender == 'kid' ? 'selected' : '' }}>kid
                                            </option>
                                        </select>
                                        <p class="error"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('product') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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
    <script src="{{ asset('asset/admin/plugins/summernote/summernote.min.js') }}"></script>
    <script src="{{ asset('asset/admin/plugins/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('asset/admin/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $('#related_product').select2({
            ajax: {
                url: '{{ route('get-product') }}',
                dataType: 'json',
                tags: true,
                multiple: true,
                minimumInputLength: 3,
                processResults: function(data) {
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
            url: "{{ route('Update-product-image') }}",
            maxFiles: 10,
            paramName: 'image',
            params: {
                'product_id': '{{ $product->id }}'
            },
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif,image/webp",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            sending: function(file, xhr, formData) {

                $("button[type=submit]").prop("disabled", true);
                $(".loading-container").addClass("active")
            },
            success: function(file, response) {


                var html = `<div class="col-md-3" id="row-image-${response.Image_id}">
                    <div class="card">
                    <input type="hidden" name="img_array[]" value="${response.Image_id}">  
                    <img src="${response.Image_path}" class="card-img-top" alt="...">
                    <div class="card-body">
                    <a href="javascript:void(0)" onclick = "deleteTempImg(${response.Image_id})" class="btn btn-danger">delete</a>
                    </div>
                    </div>
                </div>`

                $('#tempimage').append(html)
            },
            complete: function(file) {
                this.removeFile(file);
                if (this.getQueuedFiles().length === 0 && this.getUploadingFiles().length === 0) {
                    $("button[type=submit]").prop("disabled", false);
                    $(".loading-container").removeClass("active")

                }
            }
        });

        function deleteTempImg(id) {
            $('#row-image-' + id).remove();
            if (confirm('Are you Sure Went To Delete')) {
                $.ajax({
                    url: '{{ route('Delete-product-image') }}',
                    type: 'delete',
                    data: {
                        id: id
                    },
                    success: function(reponse) {
                        if (reponse.status == true) {
                            alert(reponse.msg)
                        } else {
                            alert(reponse.msg)
                        }
                    }
                });
            }

        }



        $('#productform').submit(function(event) {
            event.preventDefault();
            var element = $(this)
            $('button[type=submit]').prop('disabled', true)
            $(".loading-container").addClass("active")

            $.ajax({
                url: '{{ route('Update-product', $product->id) }}',
                type: 'post',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $('button[type=submit]').prop('disabled', true)
                    $(".loading-container").removeClass("active")

                    if (response['status'] == true) {
                        window.location.href = '{{ route('product') }}'
                        $('.error').removeClass('invalid-feedback').html('')
                        $('input,select,textarea').removeClass('is-invalid')
                    } else {
                        if (response['NotFound'] == true) {
                            window.location.href = '{{ route('product') }}'

                        }
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
