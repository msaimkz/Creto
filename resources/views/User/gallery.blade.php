@extends('User.master')
@section('content')
<!-- Gallery first section -->
<div class="Gallery-home-section sec10-dark">
    <div class="Gallery-sub-section sec7-dark">
        <h1 class="dark-icon">Gallery</h1>
        <div>
            <a href="./index.html" class="dark-anchor">Home</a>
            <span class="dark-icon">/</span>
            <a href="./Gallery.html" class="dark-anchor">Gallery</a>
        </div>
    </div>
</div>
<!-- Gallery first section -->

<!-- gallery img section-->
<div class="gallery-main-section">
    <div class="gallery-pic first-pic" id="gallery">
        <img src="{{asset('asset/user/img/gallery/gallery front1.jpg')}}" alt="" class="img-pic">
    </div>
    <div class="cloumn-pic">
        <div class="gallery-pic second-pic" id="gallery">
            <img src="{{asset('asset/user/img/gallery/gallery front3.jpg')}}" alt="" class="img-pic">
        </div>
        <div class="gallery-pic third-pic" id="gallery">
            <img src="{{asset('asset/user/img/gallery/gallery front5.jpg')}}" alt="" class="img-pic">
        </div>
    </div>
    <div class="gallery-pic fourth-pic" id="gallery">
        <img src="{{asset('asset/user/img/gallery/gallery front4.jpg')}}" alt="" class="img-pic">
    </div>
    <div class="cloumn-pic">
        <div class="gallery-pic fifth-pic" id="gallery">
            <img src="{{asset('asset/user/img/gallery/gallery front9.jpg')}}" alt="" class="img-pic">
        </div>
        <div class="gallery-pic fifth-pic" id="gallery">
            <img src="{{asset('asset/user/img/gallery/gallery front9.jpg')}}" alt="" class="img-pic picture">
        </div>
    </div>
</div>
<!-- gallery img section-->
@endsection
@section('js')
<!-- javascript link  -->
<script src="{{asset('asset/user/js/gallery.js')}}"></script>
<!-- javascript link  -->
@endsection