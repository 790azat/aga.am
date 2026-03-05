@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">

                <div class="card border-0 shadow-lg overflow-hidden">

                    <div class="row g-0">

                        <!-- LEFT IMAGE (VISIBLE ONLY DESKTOP) -->
                        <div class="col-lg-5 d-none d-lg-block">
                            <div style="
                            background: url('{{ asset('auth-images/login-image.jpg') }}');
                            background-size: cover;
                            background-position: center;
                            min-height: 600px;
                            filter: hue-rotate(167deg);
                        ">
                            </div>
                        </div>

                        <!-- FORM SIDE -->
                        <div class="col-12 col-lg-7 bg-light">

                            <div class="p-4 p-md-5">

                                <div class="text-center mb-4">
                                    <h4>
                                        {{ __('Register') }} <i class="fa-solid fa-key"></i>
                                    </h4>
                                </div>

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <!-- NAME -->
                                    <div class="mb-4">
                                        <label for="name" class="form-label">
                                            {{ __('Name') }}
                                        </label>

                                        <input id="name"
                                               type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               name="name"
                                               value="{{ old('name') }}"
                                               required
                                               autocomplete="name"
                                               autofocus>

                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

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
                                               autocomplete="email">

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
                                               autocomplete="new-password">

                                        @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- CONFIRM PASSWORD -->
                                    <div class="mb-4">
                                        <label for="password-confirm" class="form-label">
                                            {{ __('Confirm Password') }}
                                        </label>

                                        <input id="password-confirm"
                                               type="password"
                                               class="form-control"
                                               name="password_confirmation"
                                               required
                                               autocomplete="new-password">
                                    </div>

                                    <!-- SUBMIT -->
                                    <div class="d-grid mt-4">
                                        <button type="submit"
                                                class="btn btn-primary py-2">
                                            {{ __('Register') }}
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
