@extends('layouts.nav')
@section('undernav')
<br>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col"></div>
            <div class="col">They are waiting for you</div>
            <div class="col"></div>
        </div>
    </div>
    <div class="card-body">
        @foreach($news as $p)
        <br>
        <div class="card">
            <img class="card-img-top" 
            src="{{$p->post->picture}}" width="100%" height="100%">
            <div class="card-body">
                <h2>Tên: {{$p->post->name}}</h2>
                <div style="">
                <div><b>Giá:</b> {{$p->post->price}}000 VND</div>
                <br>
                <span><b>Quận:</b> {{$p->post->district}},</span>
                <span><b>Phường:</b> {{$p->post->province}}</span>
                <br>
                <br>
                <div><b>Địa chỉ:</b> {{$p->post->address}}</div>
                <br>
                <div><b>Thời gian:</b> {{$p->time}}</div>
                <br>
                <div><b>Schedule for:</b> {{$p->mode}}</div>
                </div>
                <br>
                <div><b>Attendees:</b>
                    @foreach($p->attendee as $a)
                    <br>
                    <img src="{{$a->user->info->avatar}}" width="5%" height="5%"
                    style="border-radius: 50% 50% 50% 50%">
                    <a href="profile/{{$a->user->id}}">
                        {{$a->user->name}}
                    </a>
                    <br>
                    @endforeach
                </div>
                <br>
                <div><h6>Cập nhật lúc: {{$p->updated_at}}</h6></div>
                <div class="row">
                    <div class="col">
                        <button id="save-{{$p->post->id}}" 
                        onclick="save({{$p->post->id}})" 
                        class="btn btn-outline-primary">
                        Save</button>
                    </div>
                    <div class="col">
                        <div class="dropdown">
                            <button id="attend-{{$p->id}}" class="btn btn-outline-success dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Tham gia
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <button onclick="attend({{$p->id}})"
                                    class="btn btn-outline-danger">
                                    Chắc chắn?</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        @endforeach
    </div>
</div>
@endsection