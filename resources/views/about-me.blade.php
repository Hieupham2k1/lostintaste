<!DOCTYPE html>
<html>
    <head>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div>
            Hi, i'm Phạm Trung Hiếu.
        </div>
        <div>
            My Projects:
            <div><a href="{{ route('lostintaste.welcome') }}">Lost in Taste</a></div>
            <div id="app">
            </div>
            <div id="heartcrush">
                <Heart-Crush-App />
            </div>
        </div>
    </body>
</html>