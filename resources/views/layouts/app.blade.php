<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
	<meta name="keywords" content="Lostintaste">
	<meta name="description" content="Một trang web tìm đồ ăn cho những cô cậu sinh viên">
	<meta property="og:title" content="Lostintaste">
	<meta property="og:url" content="//lostintaste.epizy.com">
	<meta property="og:type" content="product">
	<meta name="DC.language" content="scheme=utf-8 content=vi">
	<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
	<meta name="google-site-verification" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Lost in Taste</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!--VueJS-->
    {{--  có cần thiết?  --}}
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
</head>
<style>
    html{
        scroll-behavior: smooth;
        background-color: #6BBDEE;
    }
    #app{
        background-color: #6BBDEE;
        
        //background-color: darkgrey;
    }
    .reddot{
        background-color: red; 
        border-radius: 50% 50% 50% 50%;
        position: absolute;
        right: 5%;
        top: 0%;
        transform: scale(0.5) ;
        width: 10%;
    }
    .bg-yum{
        background-color: #F0B28D;
    }
    div{
        //border: 1px solid;
        text-align: center;
    }
</style>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-yum shadow-lg pb-5">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <h3>Lost in Taste</h3>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <div class="dropdown">
                        <!-- Authentication Links -->
                        @guest
                            
                                <a class="dropdown-item" href="{{ route('login') }}">{{ __('Login') }}</a>
                            
                            @if (Route::has('register'))
                                
                                    <a class="dropdown-item" href="{{ route('register') }}">{{ __('Register') }}</a>
                                
                            @endif
                        @else
                            <div class="navbar-item dropdown">
                                <a href="/home">{{Auth::user()->name}}</a>

                                <div class="" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @endguest
                        
                        </div>
                </div>
            </div>
        </nav>
        <div class=""></div>
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
    <a href="#" style="left: 80%; top: 95%" class="fixed-bottom" ><button class="btn-outline-danger" style="background-color: #6BBDEE">Go Up</button></a>
    <script>
        const load=()=>{
            const link=document.getElementById("picture");
            const link2=document.getElementById("avatar");
            document.getElementById("img").setAttribute("src", link.value);
            document.getElementById("avatar-img").setAttribute("src", link2.value);
        }
        const del=()=>{
            const link=document.getElementById("picture");
            link.value="";
            document.getElementById("img").setAttribute("src", link.value);
            const link2=document.getElementById("avatar");
            link2.value="";
            document.getElementById("img").setAttribute("src", link2.value);
        }
        const save=(id)=>{
            document.getElementById("save-"+id).innerHTML="Đã Save";
            axios.get("/newsavedpost/"+id)
            .then(
                (response)=>{
                    if(JSON.stringify(response.data).length>16)
                    alert("Bạn đã lưu bài này rồi");
                }
            )
            .catch(
                (error)=>{
                    console.log(error);
                }
            )
        }
        const attend=(id)=>{
            document.getElementById("attend-"+id).innerHTML="Đã tham gia";
            axios.get("/attend/"+id)
            .then(
                (response)=>{
                    if(JSON.stringify(response.data).length>16)
                    alert("Bạn đã tham gia rồi");
                }
            )
            .catch(
                (error)=>{
                    console.log(error);
                }
            )
        }
        const friendSearchFunction=()=>{
            const input=document.getElementById("friendSearch");
            const output=document.getElementById("friendShow");
            if(input.value!=""){
                axios.get("/getfriendshow?input="+input.value)
                .then(
                    (response)=>{
                        output.innerHTML="";
                        for(var i=0; i<response.data.length;i++){
                            output.innerHTML=output.innerHTML+
                            "<a href='profile/"+response.data[i].id+"'>"+response.data[i].name+"</a><br>";
                        }
                    }
                )
                .catch(
                    (error)=>{
                        console.log(error);
                    }
                )
            }
            else output.innerHTML="";
        }
        const addfriend=(id)=>{
            document.getElementById('addfriend-btn').innerHTML="Đã kết bạn";
            document.getElementById('dropfriend-btn').innerHTML="Hủy kết bạn";
            axios.get("/addfriend/"+id)
            .then(
                (response)=>{
                    if(JSON.stringify(response.data).length>16){
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
            axios.get("/dropfriend/"+id)
            .then(
                (response)=>{
                    if(JSON.stringify(response.data).length>16){
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
        const msg=document.getElementById('messageshow');
        
        const refresh=(id)=>{
            const msg=document.getElementById('messageshow');
            axios.get("/refresh/"+id)
            .then(
                (response)=>{
                    msg.innerHTML="";
                    const res=response.data;
                    var minindex=0, i=0;
                    while(Object.keys(res).length>0){
                        for(var index in res){
                            if(res[minindex]==undefined) minindex=index;
                            if(res[minindex].id>res[index].id) minindex=index;
                        }
                        print(id, res[minindex]);
                        delete res[minindex];
                    }
                }
            )
            .catch(
                (error)=>{
                    console.log(error);
                }
            )
        }
        setTimeout(function(){
            document.getElementById('golast').click();
        }, 50);
        var obj_id;
        const setid=(id)=>{
            obj_id=id;
        }
        setInterval(function(){
            msgCon=document.getElementById('msg-container');
            if(obj_id!=undefined){
                if(msgCon.scrollTop+msgCon.clientHeight>=msgCon.scrollHeight*9/10){
                    refresh(obj_id);
                }
            }
        }, 1000);
        msgCon=document.getElementById('msg-container');
        msgCon.scrollTop=msgCon.scrollHeight-msgCon.clientHeight;
        
        const print=(id, resmin)=>{
            const msg=document.getElementById('messageshow');
            if(resmin.subject_id==id){
                msg.innerHTML=msg.innerHTML+
                "<div class='row justify-content-start'>"+
                    "<img width='10%' heigth='10%' class='rounded-circle' src='{{$object->info->avatar??""}}'><span class='alert-warning rounded shadow mb-1'>"+resmin.content+"</span><br>"+   
                "</div>"
            }
            else{
                msg.innerHTML=msg.innerHTML+
                "<div class='row justify-content-end'>"+
                    "<span class='badge-primary rounded shadow mb-1'>"+resmin.content+"</span><img width='10%' heigth='10%' class='rounded-circle' src='{{auth()->user()->info->avatar??""}}'><br>"
                +"</div>"
            }
        }
        const enter=(event, id)=>{
            if(event.keyCode==13){
                send(id);
            }
        }
        const send=(id)=>{
            const message=document.getElementById('message');
            const msg=document.getElementById('messageshow');
            msg.scrollTop = msg.scrollHeight;
            axios.get("/sendmessage?id="+id+"&content="+message.value)
            .then(
                (response)=>{
                    message.value="";
                }
            )
            .catch(
                (error)=>{
                    console.log(error);
                }
            )
        }
    </script>
</body>
</html>
