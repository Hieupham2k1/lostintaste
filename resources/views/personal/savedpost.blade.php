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
            <div class="">{{$savedpost->links()}}</div>
            <div class="col"></div>
        </div>
        @foreach($savedpost as $p)
        <br>
        <div class="card">
            <img class="card-img-top" 
            src="{{$p->post->picture}}" width="100%" height="100%">
            <div class="card-body">
                <h2>Tên: {{$p->post->name}}</h2>
                <div>Loại: {{$p->post->kind}}</div>
                <div>Giá: {{$p->post->price}}000 VND</div>
                <span>Quận: {{$p->post->district}},</span>
                <span>Phường: {{$p->post->province}}</span>
                <div>Địa chỉ: {{$p->post->address}}</div>
                <b> Uploader:
                    <img src="{{$p->user->info->avatar}}" width="10%" height="10%"
                    style="border-radius: 50% 50% 50% 50%">
                    <a href="profile/{{$p->post->user->id}}">
                        {{$p->post->user->name}}
                    </a>
                </b> 
                <p>at {{$p->post->updated_at}}<p>
                <div>Hiển thị với: {{$p->mode}}</div>
                <div class="row">
                    <div class="col">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Hiển thị
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <a class="dropdown-item" href="update/savedpost/{{$p->id}}/all">Tất cả</a>
                                <a class="dropdown-item" href="update/savedpost/{{$p->id}}/only">Chỉ mình tôi</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="dropdown">
                            <button class="btn btn-outline-danger dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Delete
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                <a href="delete/savedpost/{{$p->id}}" style="text-decoration: none">
                                    <button class="btn btn-outline-danger">Chắc chắn?</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <a href="newschedule/{{$p->post->id}}" style="text-decoration: none">
                        <button class="btn btn-outline-primary">Schedule</button>
                        </a>
                    </div>
            </div>
        </div>
        <br>
        @endforeach
        <div class="row">
            <div class="col"></div>
            <div class="">{{$savedpost->links()}}</div>
            <div class="col"></div>
        </div>
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
                    //alert(JSON.stringify(response.data));
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