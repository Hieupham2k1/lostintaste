@extends('lostintaste.layouts.app')
@section('content')
<div class="card">
    <img class="card-img-top" src="{{ $user->info->avatar }}" alt="Food lấu đồ ăn">
    <div class="card-body">
        <h4 class="card-title">{{ $user->name }}</h4>
        <div class="card-text">
            <div class="row justify-content-start">Ngày sinh:{{ $user->info->birthdate }}</div>
            <br>
            <div class="row justify-content-start">Trường học/Công ty:{{ $user->info->workplace }}</div>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col"><button id="addfriend-btn" onclick="addfriend({{ $user->id }})" style="width: 100%" class="btn btn-outline-primary">Kết bạn</button></div>
        <div class="col"><button id="dropfriend-btn" onclick="dropfriend({{ $user->id }})" style="width: 100%" class="btn btn-outline-danger">Hủy kết bạn</button></div>
        <div class="col"><a href="{{ route('lostintaste.inbox', ['id' => $user->id]) }}"><button style="width: 100%" class="btn btn-outline-primary">Nhắn tin</button></a></div>
    </div>
</div>
<br>
<div class="card">
</div>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col">{{ $user->name }} Posts</div>
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
            page="profile" 
        />
        <div class="row">{{ $post->links() }}</div>
    </div>
</div>
<br>
<br>
<div class="card dropdown">
    <div class="card-header">{{ $user->name }} Saved Post</div>
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Show
    </button>
    <div class="dropdown-menu bg-danger" aria-labelledby="dropdownMenu1">
        Chưa hoàn thiện
    </div>
</div>
@endsection

@section('script')
    <script>
        const addfriend = (id) => {
            document.getElementById('addfriend-btn').innerHTML = "Đã kết bạn";
            document.getElementById('dropfriend-btn').innerHTML = "Hủy kết bạn";
            axios.get("{{ route('lostintaste.add_friend') }}"+id)
            .then(
                (response)=>{
                    if(response.data == 0){
                        alert("Bạn đã kết bạn với người này");
                    }
                }
            )
            .catch(
                (error)=>{
                    console.log(error);
                }
            )
        }
        const dropfriend=(id)=>{
            document.getElementById('dropfriend-btn').innerHTML="Đã hủy";
            document.getElementById('addfriend-btn').innerHTML="Kết bạn";
            axios.get("{{ route('lostintaste.add_friend') }}"+id)
            .then(
                (response)=>{
                    if(response.data == 0){
                        alert("Bạn chưa kết bạn với người này");
                    }
                }
            )
            .catch(
                (error)=>{
                    console.log(error);
                }
            )
        }
    </script>
@endsection
