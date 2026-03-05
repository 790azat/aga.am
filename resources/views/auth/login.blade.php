@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">

                <div class="card border-0 shadow-lg overflow-hidden">

                    <div class="row g-0">

                        <!-- LEFT IMAGE (HIDDEN ON SMALL DEVICES) -->
                        <div class="col-lg-5 d-none d-lg-block">
                            <div style="
                            background: url('{{ asset('auth-images/login-image.jpg') }}');
                            background-size: cover;
                            background-position: center;
                            height: 100%;
                            min-height: 500px;">
                            </div>
                        </div>

                        <!-- FORM SIDE -->
                        <div class="col-12 col-lg-7 bg-light">

                            <div class="p-4 p-md-5">

                                <div class="text-center mb-4">
                                    <h4>
                                        {{ __('Login') }} <i class="fa-solid fa-user"></i>
                                    </h4>
                                </div>

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <!-- EMAIL -->
                                    <div class="mb-4">
                                        <label for="email" class="form-label">
                                            {{ __('Email Address') }}
                                        </label>

                                        <input id="email"
                                               type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               name="email"
                                               value="{{ old('email') }}"
                                               required
                                               autocomplete="email"
                                               autofocus>

                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- PASSWORD -->
                                    <div class="mb-4">
                                        <label for="password" class="form-label">
                                            {{ __('Password') }}
                                        </label>

                                        <input id="password"
                                               type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password"
                                               required
                                               autocomplete="current-password">

                                        @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-between mb-3">
                                        <!-- REMEMBER -->
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   name="remember"
                                                   id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>

                                        <!-- FORGOT PASSWORD -->
                                        @if (Route::has('password.request'))
                                            <div class="text-center text-primary">
                                                <a class="text-decoration-none"
                                                   href="{{ route('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- BUTTON -->
                                    <div class="d-grid mb-3">
                                        <button type="submit" class="btn btn-primary py-2">
                                            {{ __('Login') }}
                                        </button>
                                    </div>

                                    <div class="col-12 d-flex justify-content-center">
                                        <button type="submit"
                                                formaction="/auth/google"
                                                formmethod="GET"
                                                formnovalidate class="gsi-material-button">
                                            <div class="gsi-material-button-state"></div>
                                            <div class="gsi-material-button-content-wrapper">
                                                <div class="gsi-material-button-icon">
                                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: block;">
                                                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                                                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                                                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
                                                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                                                        <path fill="none" d="M0 0h48v48H0z"></path>
                                                    </svg>
                                                </div>
                                                <span class="gsi-material-button-contents">Sign in with Google</span>
                                                <span style="display: none;">Sign in with Google</span>
                                            </div>
                                        </button>
                                    </div>



                                </form>

                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
@endsection
