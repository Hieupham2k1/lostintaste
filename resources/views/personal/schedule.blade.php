@extends('layouts.nav')
@section('undernav')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col"></div>
                <div class="col">Your Schedule</div>
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
                <div class="">{{ $schedule->links() }}</div>
                <div class="col"></div>
            </div>
            <Post 
                v-for="(data) in {{ json_encode($schedule->items()) }}" 
                :key="data.id" 
                :propdata="data"
                page="schedule" 
            />
            <div class="row">
                <div class="col"></div>
                <div class="">{{ $schedule->links() }}</div>
                <div class="col"></div>
            </div>
        </div>
    </div>
    <br>
    <div class="card dropdown">
        <div class="card-header">Attended</div>
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Show
        </button>
        <div class="dropdown-menu container" aria-labelledby="dropdownMenu1">
            @foreach($attended as $a)
            <br>
            <div class="card">
                <img class="card-img-top" 
                src="{{ $a->schedule->post->picture }}" width="100%" height="100%">
                <div class="card-body">
                    <h2>Tên: {{ $a->schedule->post->name }}</h2>
                    <div style="">
                    <div><b>Giá:</b> {{ $a->schedule->post->price }}000 VND</div>
                    <br>
                    <div><b>Địa chỉ:</b> {{ $a->schedule->post->address }}</div>
                    <br>
                    <div><b>Thời gian:</b> {{ $a->schedule->time }}</div>
                    <br>
                    <div><b>Schedule for:</b> {{ $a->schedule->mode }}</div>
                    </div>
                    <br>
                    <div><b>Attendees:</b>
                        @foreach($a->schedule->attendee as $attendee)
                        <br>
                        <img src="{{ $attendee->user->info->avatar ?? asset('picture/blank-img.png') }}" width="5%" height="5%"
                        style="border-radius: 50% 50% 50% 50%">
                        <a href="profile/{{ $attendee->user->id }}">
                            {{ $attendee->user->name }}
                        </a>
                        @endforeach
                    </div>
                    <br>
                    <div><h6>Cập nhật lúc: {{ $a->schedule->updated_at }}</h6></div>
                    <div class="row">
                        <div class="col">
                            <a href="{{ route('delete_attendee', ['id' => $a->id]) }}" style="text-decoration: none">
                                <button class="btn btn-outline-danger">Hủy tham gia</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            @endforeach
        </div>
    </div>
@endsection