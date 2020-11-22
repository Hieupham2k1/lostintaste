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
            <div class="">{{$schedule->links()}}</div>
            <div class="col"></div>
        </div>
        @foreach($schedule as $p)
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
                    <div>{{$a->user->name}}</div>
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
                            <button class="btn btn-outline-danger dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Delete
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                <a href="delete/schedule/{{$p->id}}" style="text-decoration: none">
                                    <button class="btn btn-outline-danger">Chắc chắn?</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <a href="update/schedule/{{$p->id}}" style="text-decoration: none">
                        <button class="btn btn-outline-primary">Update</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        @endforeach
        <div class="row">
            <div class="col"></div>
            <div class="">{{$schedule->links()}}</div>
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
    <div class="dropdown-menu bg-danger container" aria-labelledby="dropdownMenu1">
        @foreach(auth()->user()->attended as $a)
        <br>
        <div class="card">
            <img class="card-img-top" 
            src="{{$a->schedule->post->picture}}" width="100%" height="100%">
            <div class="card-body">
                <h2>Tên: {{$a->schedule->post->name}}</h2>
                <div style="">
                <div><b>Giá:</b> {{$a->schedule->post->price}}000 VND</div>
                <br>
                <span><b>Quận:</b> {{$a->schedule->post->district}},</span>
                <span><b>Phường:</b> {{$a->schedule->post->province}}</span>
                <br>
                <br>
                <div><b>Địa chỉ:</b> {{$a->schedule->post->address}}</div>
                <br>
                <div><b>Thời gian:</b> {{$a->schedule->time}}</div>
                <br>
                <div><b>Schedule for:</b> {{$a->schedule->mode}}</div>
                </div>
                <br>
                <div><b>Attendees:</b>
                    @foreach($a->schedule->attendee as $a1)
                    <img src="{{$a1->user->info->avatar}}" width="5%" height="5%"
                    style="border-radius: 50% 50% 50% 50%">
                    <a href="profile/{{$a1->user->id}}">
                        {{$a1->user->name}}
                    </a>
                    @endforeach
                </div>
                <br>
                <div><h6>Cập nhật lúc: {{$a->schedule->updated_at}}</h6></div>
                <div class="row">
                    <div class="col">
                        <button id="save-{{$a->schedule->post->id}}" 
                        onclick="save({{$a->schedule->post->id}})" 
                        class="btn btn-outline-primary">
                        Save</button>
                    </div>
                    <div class="col">
                        <a href="delete/attend/{{$a->id}}" style="text-decoration: none">
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
@push('script')
<script>
    const save=(id)=>{
        document.getElementById("save-"+id).innerHTML="Đã Save";
        axios.get("newsavedpost/"+id)
            .then(
                (response)=>{
                    //console.log("resolved:"+JSON.stringify(response.data));
                    if(JSON.stringify(response.data).length>16)
                    alert(JSON.stringify(response.data));
                }
            )
            .catch(
                (error)=>{
                    //this.$refs.divshow.innerHTML=error;
                    console.log(error);
                }
            )
    }
</script>
@endpush