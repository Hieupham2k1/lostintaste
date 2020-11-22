@extends('layouts.nav')
@section('undernav')
<br>
<div class="card" onmousemove="setid({{$object->id}})">
    <div class="card-header">
        <div class="card-header">{{$object->name}}<br>
            <a href="#last"><button id="golast" class="btn-primary">xuống cuối</button></a></div>
    </div>
    <div class="card-body" id="msg-container" onscroll="setid({{$object->id}})" style="height:500px; overflow: scroll">
        <div id="messageshow">
            @foreach($inbox as $i)
            @if($i->subject->id==auth()->user()->id)
            <div class="row justify-content-end">
                <span class="badge-primary rounded shadow mb-1">{{$i->content}}</span><img width="10%" heigth="10%" class="rounded-circle" src="{{$i->subject->info->avatar}}"><br>
            </div>
            @else
            <div class="row justify-content-start">
                <img width="10%" heigth="10%" class="rounded-circle" src="{{$i->subject->info->avatar}}"><span class="alert-warning rounded shadow mb-1">{{$i->content}}</span><br>   
            </div>
                @endif
            @endforeach
        </div>
        <div id='last'></div>
    </div>
    <div class="input-group">
        <input id="message" onkeyup="enter(event, {{$object->id}})" type="text" class="form-control" aria-describedby="basic-addon1">
        <div class="input-group-append">
            <button id="send-btn" onclick="send({{$object->id}})" class="btn btn-primary" type="button">Send</button>
        </div>
    </div>
</div>
@endsection