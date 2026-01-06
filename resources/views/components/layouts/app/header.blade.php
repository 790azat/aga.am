<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>

<body class="min-vh-100 bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">

        <!-- Mobile toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="navbar-brand ms-2">
            <x-app-logo />
        </a>

        <!-- Desktop menu -->
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a
                        href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    >
                        Dashboard
                    </a>
                </li>
            </ul>

            <!-- Right menu -->
            <ul class="navbar-nav align-items-center gap-2">

                <li class="nav-item">
                    <a class="nav-link" href="#" title="Search">
                        🔍
                    </a>
                </li>

                <li class="nav-item d-none d-lg-block">
                    <a class="nav-link" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                        Repository
                    </a>
                </li>

                <li class="nav-item d-none d-lg-block">
                    <a class="nav-link" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                        Docs
                    </a>
                </li>

                <!-- User dropdown -->
                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                    >
                        {{ auth()->user()->initials() }}
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="px-3 py-2">
                            <div class="fw-semibold">{{ auth()->user()->name }}</div>
                            <div class="text-muted small">{{ auth()->user()->e
