@extends('layouts.app')

@section('content')
    <div class="col-12 d-flex">
        <div class="col-2 d-flex flex-column justify-content-start gap-4" id="content">
            <div class="col-8 mx-auto text-nowrap text-light mt-5">
                <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-home me-1"></i> Dashboard</a>
            </div>
            <div class="col-8 mx-auto text-nowrap text-secondary">
                <a href="{{ route('admin.moderators') }}"><i class="fa-solid fa-user-tie me-1"></i> Moderators</a>
            </div>
            <div class="col-8 mx-auto text-nowrap text-secondary">
                <a href="{{ route('admin.videos') }}"><i class="fa-solid fa-video me-1"></i> Videos</a>
            </div>
            <div class="col-8 mx-auto text-nowrap text-secondary">
                <a href="{{ route('admin.users') }}"><i class="fa-solid fa-users me-1"></i> Users</a>
            </div>
            <div class="col-8 mx-auto text-nowrap text-secondary">
                <a href="{{ route('admin.settings') }}"><i class="fa-solid fa-gear me-1"></i> Settings</a>
            </div>
            <div class="col-8 mx-auto text-nowrap text-danger">
                <a href="{{ route('logout') }}"><i class="fa-solid fa-right-from-bracket me-1"></i> Logout</a>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>

        </div>
        <div class="col bg-light">
            @yield('admin')
        </div>
    </div>
    <script>
        const navbar = document.getElementById('navbar');
        const content = document.getElementById('content');

        content.style.minHeight = `calc(100vh - ${navbar.offsetHeight}px)`;
    </script>
@endsection
