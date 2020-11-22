@extends('layouts.nav')
@section('undernav')
<br>
<div class="card">
    <input id="friendSearch" onkeyup="friendSearchFunction()" type="text" class="form-control" placeholder="Tìm bạn bè">
    <div id="friendShow" class="z-index"></div>
</div>
<br>
<br>
<div class="card dropdown">
    <div class="card-header">Your Friends</div>
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Show
    </button>
    <div class="dropdown-menu container" aria-labelledby="dropdownMenu1">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Bạn có thể quen</div>
                    {{--<div class="">{{$mightknow->links()}}</div>--}}
                    @foreach($mightknow as $f)
                        <div><a href="profile/{{$f->id??""}}"><img width="10%" heigth="10%" class="rounded-circle" src="{{$f->info->avatar??""}}">{{$f->name??""}}</a></div>
                    @endforeach
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">Your Friends</div>
                    @foreach($friend as $f)
                        <div><a href="profile/{{$f->id}}"><img width="10%" heigth="10%" class="rounded-circle" src="{{$f->info->avatar}}">{{$f->name}}</a></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="card">
    <div class="card-header">Your Friends Post</div>
    @foreach($friendspost as $p)
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
                    <a href="profile/{{$p->user->id}}">
                        <img width="5%" heigth="5%" class="rounded-circle" src="{{$p->user->info->avatar}}">{{$p->user->name}}
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
                        <a href="newschedule/{{$p->id}}" style="text-decoration: none">
                        <button class="btn btn-outline-primary">Schedule</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        @endforeach
</div>
@endsection