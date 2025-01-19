@extends('User.master')
@section('content')
<div class="blog-detail-container mt-5 mb-5">
    <div class="blog-img-container">
        <img src="{{asset('uploads/News/thumb/large/'.$news->img)}}" alt="">
        <div class="blog-aurthor-section">
            <p><i class="fa-solid fa-calendar-days"></i>&nbsp;&nbsp; <span>{{ \Carbon\Carbon::parse($news->created_at)->format('M,Y, d') }}</span></p>
            <p><i class="fa-solid fa-user"></i>&nbsp;&nbsp; <span>By {{ $news->writer }}</span></p>
        </div>
    </div>
    <div class="blog-text-container mt-4">
        <h1 class="nav-nigth">{{ $news->title }}</h1>
        <p class="mt-5" class="nav-nigth">{!! $news->descripion !!}</p>
    </div>
</div>
@endsection