@extends('User.master')
@section('content')
<div class="section8">
    <h1 class="nav-nigth"> Our News</h1>
    <div class="sec8-card-container">
    @if($news->isNotEmpty())
        @foreach($news as $new)
        <div class="sec8-card sec8-dark">
            <h2 class="sec8-nav-nigth">{{$new->title}}</h2>
            <div class="sec8-card-imgbox">
                <img src="{{asset('uploads/News/thumb/small/'.$new->img)}}" alt="">
                <div class="blackshadow"></div>
            </div>
            <div class="sec8-card-contentbox">
                <div class="time-box">
                    <i class="fa-solid fa-calendar-days sec4-dark-icon"></i>
                    <span class="nav-nigth">dec 15 2023</span>
                    <i class="fa-solid fa-user sec4-dark-icon"></i>
                    <span class="nav-nigth ">By {{$new->writer}}</span>
                </div>
                <p class="nav-nigth">{!! $new->short_descripion !!}</p>
                <a href="{{ route('Blog-Detail',$new->id) }}" class="dark-anchor">Read More</a>
            </div>
        </div>
        @endforeach
        @else
        <h1 class="Not-found">News Not Found</h1>
        @endif
    </div>
</div>
@endsection