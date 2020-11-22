@extends('layouts.app')
@section('content')
<div class="card">
    <img class="card-img-top" src="{{$user->info->avatar}}" alt="Food lấu đồ ăn">
    <div class="card-body">
        <h4 class="card-title">{{$user->name}}</h4>
        <div class="card-text">
            <div class="row justify-content-start">Ngày sinh:{{$user->info->birthdate}}</div>
            <br>
            <div class="row justify-content-start">Trường học/Công ty:{{$user->info->workplace}}</div>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col"><button id="addfriend-btn" onclick="addfriend({{$user->id}})" style="width: 100%" class="btn btn-outline-primary">Kết bạn</button></div>
        <div class="col"><button id="dropfriend-btn" onclick="dropfriend({{$user->id}})" style="width: 100%" class="btn btn-outline-danger">Hủy kết bạn</button></div>
        <div class="col"><a href="/inbox/{{$user->id}}"><button style="width: 100%" class="btn btn-outline-primary">Nhắn tin</button></a></div>
    </div>
</div>
<br>
<div class="card">
</div>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col">{{$user->name}} Posts</div>
        </div>
    </div>
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="row" style="">{{$post->links()}}</div>
        @foreach($post as $p)
        <br>
        <div class="card">
            <img class="card-img-top" 
            src="{{$p->picture}}" width="100%" height="100%">
            <div class="card-body">
                <h2>Tên: {{$p->name}}</h2>
                <div>Loại: {{$p->kind}}</div>
                <div>Giá: {{$p->price}}000 VND</div>
                <span>Quận: {{$p->district}},</span>
                <span>Phường: {{$p->province}}</span>
                <div>Địa chỉ: {{$p->address}}</div>
                <b> Uploader:
                    <img src="{{$p->picture}}" width="10%" height="10%"
                    style="border-radius: 50% 50% 50% 50%">
                    <a href="/profile/{{$p->user->id}}">
                        {{$p->user->name}}
                    </a>
                </b> 
                <p>at {{$p->updated_at}}<p>
                <div class="row">
                    <div class="col">
                        <button id="save-{{$p->id}}" 
                            onclick="save({{$p->id}})" 
                            class="btn btn-outline-primary">
                            Save</button>
                    </div>
                    <div class="col">
                        <a href="/newschedule/{{$p->id}}" style="text-decoration: none">
                        <button class="btn btn-outline-primary">Schedule</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        @endforeach
        <div class="row">{{$post->links()}}</div>
    </div>
</div>
<br>
<br>
<div class="card dropdown">
    <div class="card-header">{{$user->name}} Saved Post</div>
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Show
    </button>
    <div class="dropdown-menu bg-danger" aria-labelledby="dropdownMenu1">
        @foreach($savedpost as $p)
        <br>
        <div class="card">
            <img class="card-img-top" 
            src="{{$p->post->picture}}" width="100%" height="100%">
            <div class="card-body">
                <h2>Tên: {{$p->post->name}}</h2>
                <div>Loại: {{$p->post->kind}}</div>
                <div>Giá: {{$p->post->price}}000 VND</div>
                <span>Quận: {{$p->post->district}},</span>
                <span>Phường: {{$p->post->province}}</span>
                <div>Địa chỉ: {{$p->post->address}}</div>
                <b> Uploader:
                    <img src="{{$p->post->picture}}" width="10%" height="10%"
                    style="border-radius: 50% 50% 50% 50%">
                    <a href="/profile/{{$p->post->user->id}}">
                        {{$p->post->user->name}}
                    </a>
                </b> 
                <p>at {{$p->post->updated_at}}<p>
                <div>Hiển thị với: {{$p->mode}}</div>
                <div class="row">
                    <div class="col">
                        <button id="save-{{$p->id}}" 
                            onclick="save({{$p->id}})" 
                            class="btn btn-outline-primary">
                            Save</button>
                    </div>
                    <div class="col">
                        <a href="/newschedule/{{$p->post->id}}" style="text-decoration: none">
                        <button class="btn btn-outline-primary">Schedule</button>
                        </a>
                    </div>
            </div>
        </div>
        <br>
    @endforeach
    </div>
</div>
@endsection
@push('script')
@endpush
