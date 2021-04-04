@extends('lostintaste::layouts.nav')
@section('undernav')
<br>
<div class="card">
    <div class="card-header">{{ (isset($schedule)) ? 'Update' : 'New' }} Schedule</div>
    <div class="card-body">
        <form method="POST" action="{{ route('lostintaste.insert_schedule') }}">
            @csrf
            <input name="id" value="{{ $schedule->id ?? '' }}" style="display:none">
            <div class="card">
                <img class="card-img-top" 
                src="{{ $post->picture }}" width="100%" height="100%">
                <div class="card-body">
                    <h2>Tên: {{ $post->name }}</h2>
                    <div>Giá: {{ $post->price }} 000 VND</div>
                    <div>Địa chỉ: {{ $post->address }}</div>
                </div>

                <input name="post_id" value={{ $post->id }} style="display:none">
                <label for="time" class="col-form-label ">Thời gian</label>
                <input type="text" 
                class="form-control @error('time') is-invalid @enderror" 
                name="time" value="{{ $schedule->time ?? 'CN, 19/7/2020, 19:00' }}"
                required autofocus>
                <br>
                <select class="custom-seclect form-control" name="mode">
                    <option>Squad</option>
                    <option>Duo</option>
                    <option>Solo</option>
                </select>
                <br>
            </div>                
            <button type="submit" class="btn btn-primary">
                {{ (isset($schedule)) ? 'Update' : 'New' }}
            </button>
        </form>
    </div>
</div>
@endsection