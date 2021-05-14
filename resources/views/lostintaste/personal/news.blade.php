@extends('lostintaste.layouts.nav')
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
    <Post 
        v-for="(data) in {{ $news }}" 
        :key="data.id" 
        :propdata="data"
        page="news" 
    />
</div>
@endsection