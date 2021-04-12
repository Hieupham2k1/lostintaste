@extends('vue-apps', ['exclude' => 'heartcrush'])

@extends('heartcrush::layouts.master')

@section('content')
    <div id="heartcrush">
        <Heart-Crush-App />
    </div>
@endsection
