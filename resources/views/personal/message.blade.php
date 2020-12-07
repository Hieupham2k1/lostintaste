@extends('layouts.nav')
@section('undernav')
<br>
<div class="card">
    <div class="row">
        <div class="col"></div>
        <div class="col">Your Messages</div>
        <div class="col"><a href="friend">+New Message</a></div>
    </div>
    <div class="card-body">
        @foreach($message as $m)
            <a href="{{ route('inbox', ['id' => $m->object->id ?? '']) }}">
                <img width="5%" heigth="5%" class="rounded-circle" src="{{ $m->object->info->avatar ?? '' }}"> {{ $m->object->name ?? '' }}
            </a>
            <br>
            <a href="{{ route('inbox', ['id' => $m->subject->id ?? '']) }}">
                <img width="5%" heigth="5%" class="rounded-circle" src="{{ $m->subject->info->avatar ?? '' }}"> {{ $m->subject->name ?? '' }}
            </a>
            <br>
        @endforeach
    </div>
</div>
@endsection