@extends('User.master')

@section('content')
<section class="section-11">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2 Profile-heading">Personal Information</h2>
                    </div>
                    <div class="card-body p-4">
                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                        </form>

                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            <div class="row">
                                <div class="mb-3">
                                    <input type="hidden" id="profileImg" name="profileImg">
                                    <div class="profile-image-container">
                                        @if(!empty($user->profile_img))
                                        <img id="profile-img-box"
                                            src="{{ asset('uploads/profile/thumb/'.$user->profile_img) }}" alt="">
                                        @else
                                        <img id="profile-img-box" src="{{ asset('uploads/profile/default.png') }}"
                                            alt="">
                                        @endif

                                        <div class="dropzone-imag-upload">
                                            <img src="{{ asset('asset/user/img/Thanks/image-uploads2.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="profile-label" for="name">Name</label>
                                    <input type="text" name="name" id="name" placeholder="Enter Your Name"
                                        class="form-control profile-input" value="{{old('name', $user->name)}}" required
                                        autofocus autocomplete="name">
                                    <span class="text-danger mt-2" >{{ implode(', ', $errors->get('name')) }}</span>
                                </div>

                                <div class="mb-3">
                                    <label class="profile-label" for="email">Email</label>
                                    <input type="email" name="email" id="email" placeholder="Enter Your Email"
                                        class="form-control profile-input" value="{{old('email', $user->email)}}"
                                        required autocomplete="username">
                                        <span class="text-danger mt-2" >{{ implode(', ', $errors->get('email')) }}</span>


                                   
                                </div>

                                <div class="mb-3">
                                    <label class="profile-label" for="phone">Phone</label>
                                    <input type="text" name="mobile" id="mobile" placeholder="Enter Your Phone"
                                        class="form-control profile-input" value="{{old('mobile', $user->mobile)}}">
                                    <span class="text-danger mt-2" >{{ implode(', ', $errors->get('mobile')) }}</span>

                                </div>

                                <div class="d-flex profile-button-container">
                                    <button type="submit" class="btn profile-button">Update</button>
                                    <div>
                                        <a href="{{ route('profile.change-password') }}"
                                            class="btn profile-button">Change Password</a>
                                        <button class="btn profile-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">
                                            Delete Account
                                        </button>
                                    </div>
                                </div>

                                @if (session('status') === 'profile-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition
                                    x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                                    {{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Button trigger modal -->


<!-- Modal -->

<!-- Bootstrap Modal Structure -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmUserDeletionLabel">Are You Sure You Want To Delete Your Account?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>

                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="mb-3">
                        <label class="form-label profile-label" for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Password" class="form-control profile-input">
                        
                        @foreach ($errors->userDeletion->get('password') as $message)
                            <span class="text-danger">{{ $message }}</span><br>
                        @endforeach
                    </div>

                    <div class="d-flex delete-button-container">
                        <button type="button" class="btn btn profile-button"data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="submit" class="btn  profile-button delete-button">Delete Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="{{asset('asset/admin/plugins/dropzone/dropzone.js')}}"></script>
<script>
Dropzone.autoDiscover = false;
const dropzone = $(".dropzone-imag-upload img").dropzone({
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
        $("#profileImg").val(response.Image_id);
        $("#profile-img-box").attr("src", response.Image_path);

    }
});
</script>

@endsection