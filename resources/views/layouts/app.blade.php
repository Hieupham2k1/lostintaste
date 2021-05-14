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

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<style>
    html{
        scroll-behavior: smooth;
        background-color: #6BBDEE;
        background-image: linear-gradient(135deg, #6BBDEE, white);
    }
    #app{
        background-color: #6BBDEE;
        background-image: linear-gradient(135deg, #6BBDEE, white);
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
        background-image: linear-gradient(white, #6BBDEE);
    }
    div{
        text-align: center;
    }
</style>
<body>
    @extends('vue-apps', ['exclude' => 'app'])
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-yum shadow-lg pb-5">
            <div class="container">
                <a class="navbar-brand" href="{{ route('lostintaste.welcome') }}">
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
                                <a href="{{ route('lostintaste.self_info') }}">{{ Auth::user()->name }}</a>

                                <div class="" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                        Logout
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
    <a href="#" style="left: 80%; top: 95%" class="fixed-bottom" ><button class="btn btn-outline-danger">Go Up</button></a>
    @yield('script')
</body>
</html>