@extends('layouts.nav')
@section('undernav')
<div class="card">
    <img class="card-img-top" src="{{auth()->user()->info->avatar??""}}" alt="Food lấu đồ ăn">
    <div class="card-body">
    <h4 class="card-title">{{auth()->user()->name??""}}</h4>
    <div class="card-text">
        <div class="row justify-content-start">Ngày sinh:{{auth()->user()->info->birthdate??""}}</div>
        <br>
        <div class="row justify-content-start">Trường học/Công ty:{{auth()->user()->info->workplace??""}}</div>
        <br>
    </div>
    <a href="update/user/{{auth()->user()->id}}" class="btn btn-primary">Chỉnh sửa</a>
    </div>
</div>
@endsection

