@extends('lostintaste.layouts.nav')
@section('undernav')
<div class="card">
    <img class="card-img-top" src="{{ $user->info->avatar ?? asset('picture/blank-img.png') }}" alt="Food lấu đồ ăn">
    <div class="card-body">
    <h4 class="card-title">{{ $user->name ?? '' }}</h4>
    <div class="card-text">
        <div class="row justify-content-start">Ngày sinh: {{ $user->info->birthdate ?? '' }}</div>
        <br>
        <div class="row justify-content-start">Trường học/Công ty: {{ $user->info->workplace ?? '' }}</div>
        <br>
    </div>
    <a href="{{ route('lostintaste.update_user', ['id' => $user->id]) }}" class="btn btn-primary">Chỉnh sửa</a>
    </div>
</div>
@endsection

