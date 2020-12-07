@extends('layouts.app')
@section('content')
<div class="row">
    <div class="card col-12">
        <div class="card">
            <video width="100%"playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop" class="bg-dark">
                <source   src="{{ asset('picture/grilled-steak.mp4') }}" type="video/mp4">
            </video>
            <div class="card-img-overlay">
                <h2 class="card-text text-white">Bạn cần 1 cái cớ để rủ crush đi chơi?</h2>
                <div><a class="btn btn-primary text-white" href="{{ route('searcher') }}">Search</a></div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row card">
<div class="card-header col-12">Top Yummiest foods</div>
</div>
<div class="row">
    @foreach($topfoods as $food)
        <div class="card col-4">
            <img src={{ $food->picture }} class="card-img-top" alt="food lẩu đồ ăn" width="100%" height="100%">
        </div>
    @endforeach
</div>
<br>
<div class="row card">
    <div class="card-header">Đây là trang gì vậy?</div>
    <div class="card-body">
        Ở đây, bạn có thể tìm những món ăn quanh Hà Nội, những địa điểm
        mà bạn chưa đến hoặc chưa từng dừng chân dù đã lướt qua nhiều lần.
        Tại sao tôi lại tạo ra nơi này? Là dành cho tôi, những introvert
        cần 1 cái cớ để ra ngoài kết bạn. Bây giờ thì đứng thẳng lên và đặt
        1 lịch hẹn đi nào!
    </div>
@endsection
