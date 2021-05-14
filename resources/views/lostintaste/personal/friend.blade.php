@extends('lostintaste.layouts.nav')
@section('undernav')
<br>
<div class="card">
    <input id="friendSearch" onkeyup="searchFriend()" type="text" class="form-control" placeholder="Tìm bạn bè">
    <div id="friendShow" class="z-index"></div>
</div>
<br>
<br>
<div class="card dropdown">
    <div class="card-header">Your Friends</div>
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Show
    </button>
    <div class="dropdown-menu container" aria-labelledby="dropdownMenu1">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Bạn có thể quen</div>
                    @foreach($mightknow as $f)
                        <div><a href="{{ route('lostintaste.profile', ['id' => $f->id]) }}"><img width="10%" heigth="10%" class="rounded-circle" src="{{$f->info->avatar??""}}">{{$f->name??""}}</a></div>
                    @endforeach
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">Your Friends</div>
                    @foreach($friend as $f)
                        <div><a href="{{ route('lostintaste.profile', ['id' => $f->id]) }}"><img width="10%" heigth="10%" class="rounded-circle" src="{{$f->info->avatar}}">{{$f->name}}</a></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="card">
    <div class="card-header">Your Friends Post</div>
    Chưa hoàn thành
</div>
@endsection

@section('script')
    <script>
        const searchFriend = () => {
            const input = document.getElementById("friendSearch");
            const output = document.getElementById("friendShow");
            if(input.value != ""){
                axios.get("{{ route('lostintaste.search_friend') }}/" + input.value)
                .then(
                    (response) => {
                        output.innerHTML = "";
                        for(var i=0; i<response.data.length;i++){
                            output.innerHTML += 
                            "<a href='profile/" + response.data[i].id + "'>"
                                + response.data[i].name + 
                            "</a><br>";
                        }
                    }
                )
                .catch(
                    (error)=>{
                        console.log(error);
                    }
                )
            }
            else output.innerHTML = "";
        }
    </script>
@endsection