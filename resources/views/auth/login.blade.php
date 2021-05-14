@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Login</div>

    <div class="card-body">
        <form name="login" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row" style="display:none">
                <div class="col-md-6 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            Remember Me
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col">
                    <button class="btn" onclick="loginAsInterviewer(event)" form="not_here">
                        For interviewer
                    </button>
                </div>

                <div class="col-12 col-md-4 my-3">
                    <button class="btn btn-primary">
                        Login
                    </button>
                </div>
                
                <div class="col">
                    <a class="dropdown-item" href="{{ route('register') }}">{{ __('Register') }}</a>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            Forgot Your Password?
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
    <script>
        const loginAsInterviewer = () => {
            const form = document.forms['login'];
            form['email'].value = "interviewer@gmail.com";
            form['password'].value = "12345678";
            form.submit();
        }
    </script>
@endsection
