@extends('layouts.nav')
@section('undernav')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col"></div>
            <div class="col">Your Posts</div>
            <div class="col"><a href="push" class="">+New Post</a></div>
        </div>
    </div>
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="row" style="">{{$post->links()}}</div>
        @foreach($post as $p)
        <br>
        <div class="card">
            <img class="card-img-top" 
            src="{{$p->picture}}" width="100%" height="100%">
            <div class="card-body">
                <h2>Tên: {{$p->name}}</h2>
                <div>Loại: {{$p->kind}}</div><br>
                <div>Giá: {{$p->price}}000 VND</div><br>
                <span>Quận: {{$p->district}},</span>
                <span>Phường: {{$p->province}}</span><br><br>
                <div>Địa chỉ: {{$p->address}}</div><br>
                <b> Uploader:
                    <img src="{{$p->user->info->avatar}}" width="10%" height="10%"
                    style="border-radius: 50% 50% 50% 50%">
                    <a href="profile/{{$p->user->id}}">
                        {{$p->user->name}}
                    </a>
                </b> 
                <p>at {{$p->updated_at}}<p>
                <div class="row">
                    <div class="col">
                        <button id="save-{{$p->id}}" 
                            onclick="save({{$p->id}})" 
                            class="btn btn-outline-primary">
                            Save</button>
                    </div>
                    <div class="col">
                        <div class="dropdown">
                            <button class="btn btn-outline-danger dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Update
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                <a href="delete/post/{{$p->id}}" style="text-decoration: none">
                                    <button class="btn btn-outline-danger">Delete</button>
                                </a>
                                <a href="update/post/{{$p->id}}" style="text-decoration: none">
                                    <button class="btn btn-outline-success">Update</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <a href="newschedule/{{$p->id}}" style="text-decoration: none">
                        <button class="btn btn-outline-primary">Schedule</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        @endforeach
        <div class="row">{{$post->links()}}</div>
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
                    alert("Bạn đã lưu bài này rồi");
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
