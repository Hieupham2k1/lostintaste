@extends('layouts.nav')
@section('undernav')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col"></div>
                <div class="col">Your Saved Posts</div>
                <div class="col"></div>
            </div>
        </div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="row">
                <div class="col"></div>
                <div class="">{{ $savedpost->links() }}</div>
                <div class="col"></div>
            </div>
            <Post 
                v-for="data in {{ json_encode($savedpost->items()) }}" 
                :key="data.id" 
                :propdata="data"
                page="savedpost" 
            />
            <div class="row">
                <div class="col"></div>
                <div class="">{{ $savedpost->links() }}</div>
                <div class="col"></div>
            </div>
        </div>
    </div>
@endsection