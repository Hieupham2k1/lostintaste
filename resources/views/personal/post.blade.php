@extends('layouts.nav')
@section('undernav')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col"></div>
            <div class="col">Your Posts</div>
            <div class="col"><a href="{{ route('new_post') }}" class="">+New Post</a></div>
        </div>
    </div>
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="row" style="">{{ $post->links() }}</div>

        <Post 
            v-for="(data) in {{ json_encode($post->items()) }}" 
            :key="data.id" 
            :propdata="data"
            page="post" 
        />

        <div class="row">{{$post->links()}}</div>
    </div>
</div>
@endsection
