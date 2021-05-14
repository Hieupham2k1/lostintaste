@extends('lostintaste.layouts.nav')
@section('undernav')
<br>
Chưa hoàn thành
{{--  cần tối ưu  --}}
{{--  <div class="card" onmousemove="setId({{ $object->id }})">
    <div class="card-header">
        <div class="card-header">{{ $object->name }}<br>
            <a href="#last"><button id="golast" class="btn-primary">xuống cuối</button></a></div>
    </div>
    <div class="card-body" id="msg-container" onscroll="setId({{ $object->id }})" style="height:500px; overflow: scroll">
        <div id="messageshow">
            @foreach($inbox as $i)
            @if($i->subject->id == auth()->user()->id)
            <div class="row justify-content-end">
                <span class="badge-primary rounded shadow mb-1">{{ $i->content }}</span><img width="10%" heigth="10%" class="rounded-circle" src="{{$i->subject->info->avatar}}"><br>
            </div>
            @else
            <div class="row justify-content-start">
                <img width="10%" heigth="10%" class="rounded-circle" src="{{ $i->subject->info->avatar }}"><span class="alert-warning rounded shadow mb-1">{{$i->content}}</span><br>   
            </div>
                @endif
            @endforeach
        </div>
        <div id='last'></div>
    </div>
    <div class="input-group">
        <input id="message" onkeyup="enter(event, {{ $object->id }})" type="text" class="form-control" aria-describedby="basic-addon1">
        <div class="input-group-append">
            <button id="send-btn" onclick="send({{ $object->id }})" class="btn btn-primary" type="button">Send</button>
        </div>
    </div>
</div>  --}}
@endsection

@section('script')
    <script>
        const msg = document.getElementById('messageshow');
        const msgCon = document.getElementById('msg-container');
        setTimeout(function(){
            document.getElementById('golast').click();
        }, 50);
        var obj_id;
        setInterval(function(){
            if(obj_id != undefined){
                if(msgCon.scrollTop + msgCon.clientHeight >= msgCon.scrollHeight * 9 / 10){
                    refresh(obj_id);
                }
            }
        }, 1000);
        msgCon = document.getElementById('msg-container');
        msgCon.scrollTop = msgCon.scrollHeight-msgCon.clientHeight;
            
        const setId = (id) => {
            obj_id = id;
        }

        const refresh = (id) => {
            axios.get("/refresh/"+id)
            .then(
                (response) => {
                    msg.innerHTML = "";
                    const res = response.data;
                    var minindex = 0, i = 0;
                    while(Object.keys(res).length > 0){
                        for(var index in res){
                            if(res[minindex] == undefined || res[minindex].id > res[index].id) minindex = index;
                        }
                        print(id, res[minindex]);
                        delete res[minindex];
                    }
                }
            )
            .catch(
                (error) => {
                    console.log(error);
                }
            )
        }
        
        const print = (id, resmin) => {
            if(resmin.subject_id == id){
                msg.innerHTML +=
                "<div class='row justify-content-start'>"
                    + "<img width='10%' heigth='10%' class='rounded-circle' src='{{ $object->info->avatar ?? "" }}'><span class='alert-warning rounded shadow mb-1'>"
                        + resmin.content
                        + "</span><br>"   
                + "</div>";
            }
            else{
                msg.innerHTML +=
                "<div class='row justify-content-end'>"
                    + "<span class='badge-primary rounded shadow mb-1'>"
                        + resmin.content
                        + "</span><img width='10%' heigth='10%' class='rounded-circle' src='{{ auth()->user()->info->avatar ?? "" }}'><br>"
                + "</div>";
            }
        }
        const enter = (event, id) => {
            if(event.keyCode == 13){
                send(id);
            }
        }
        const send = (id) => {
            const message = document.getElementById('message');
            msg.scrollTop = msg.scrollHeight;
            axios.get("{{ route('lostintaste.send_message') }}?id="+id+"&content="+message.value)
            .then(
                (response) => {
                    message.value = "";
                }
            )
            .catch(
                (error) => {
                    console.log(error);
                }
            )
        }
    <script>
@endsection