@extends('User.master')
@section('content')
<div class="blog-detail-container mt-5 mb-5">
    <div class="blog-text-container mt-4">
        <h1 class="nav-nigth">{{ $service->title }}</h1>
        <p class="mt-5" class="nav-nigth">{!! $service->description !!}</p>
    </div>
</div>
@endsection