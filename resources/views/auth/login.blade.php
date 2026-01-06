@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex col-12" style="height: 500px">
                <div class="col-5 rounded-start-2 overflow-hidden">
                    <div style="background: url('{{ asset('auth-images/login-image.jpg') }}');background-size: cover;height: 100%" alt="">
                    </div>
                </div>
                <div class="card border-0 rounded-start-0 rounded-end-2 bg-light col overflow-hidden">
                    <div class="card-header pt-5 border-bottom-0 text-center bg-light">{{ __('Login') }} <i class="fa-solid fa-user"></i></div>

                    <div class="card-body d-flex justify-content-center pt-5">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end text-nowrap">{{ __('Email Address') }}</label>

                                <div class="col">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end text-nowrap">{{ __('Password') }}</label>

                                <div class="col">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mx-auto">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 mx-auto d-flex flex-wrap justify-content-center">
                                    <div class="col-12 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Login') }}
                                        </button>
                                    </div>

                                    @if (Route::has('password.request'))
                                        <div class="col-12 text-center">
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

