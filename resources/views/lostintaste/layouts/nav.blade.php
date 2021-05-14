@extends('lostintaste.layouts.app')
@section('content')
<div class="card">
    <div class="row">
        <div class="col"><a href="{{ route('lostintaste.news') }}"><button style="width: 100%" class="btn btn-outline-primary">News<div class="reddot">...</div></button></a></div>
        <div class="col"><a href="{{ route('lostintaste.message') }}"><button style="width: 100%" class="btn btn-outline-primary">Messages</button></a></div>
    </div>
</div>
<div class="card">
    <div class="row">
        <div class="col"><a href="{{ route('lostintaste.post') }}"><button style="width: 100%" class="btn btn-outline-primary">Posts</button></a></div>
        <div class="col"><a href="{{ route('lostintaste.schedule') }}"><button style="width: 100%" class="btn btn-outline-primary">Schedules</button></a></div>
    </div>
</div>
<div class="card">
    <div class="row">
        <div class="col"><a href="{{ route('lostintaste.savedpost') }}"><button style="width: 100%" class="btn btn-outline-primary">Saved Posts</button></a></div>
        <div class="col"><a href="{{ route('lostintaste.friend') }}"><button style="width: 100%" class="btn btn-outline-primary">Friends</button></a></div>
    </div>
</div>
<br>
@yield('undernav')
@endsection
