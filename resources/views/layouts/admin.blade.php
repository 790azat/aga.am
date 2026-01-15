@extends('layouts.app')

@section('content')
    <div class="col-12 d-flex">
        <div class="col-2 d-flex flex-column justify-content-start gap-4" id="content">

            <div class="col-8 mx-auto text-nowrap {{ Route::is('admin.dashboard') ? 'text-light' : 'text-secondary' }} mt-5">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa-solid fa-gauge-high me-1"></i> Dashboard
                </a>
            </div>

            <div class="col-8 mx-auto text-nowrap {{ Route::is('admin.moderators*') ? 'text-light' : 'text-secondary' }}">
                <a href="{{ route('admin.moderators') }}">
                    <i class="fa-solid fa-user-tie me-1"></i> Moderators
                </a>
            </div>

            <div class="col-8 mx-auto text-nowrap {{ Route::is('admin.videos*') ? 'text-light' : 'text-secondary' }}">
                <a href="{{ route('admin.videos') }}">
                    <i class="fa-solid fa-video me-1"></i> Videos
                </a>
            </div>

            <div class="col-8 mx-auto text-nowrap {{ Route::is('admin.users*') ? 'text-light' : 'text-secondary' }}">
                <a href="{{ route('admin.users') }}">
                    <i class="fa-solid fa-users me-1"></i> Users
                </a>
            </div>

            <div class="col-8 mx-auto text-nowrap {{ Route::is('admin.cashier*') ? 'text-light' : 'text-secondary' }}">
                <a href="{{ route('admin.cashier') }}">
                    <i class="fa-solid fa-cash-register me-1"></i> Cashier
                </a>
            </div>

            <div class="col-8 mx-auto text-nowrap {{ Route::is('admin.history*') ? 'text-light' : 'text-secondary' }}">
                <a href="{{ route('admin.history') }}">
                    <i class="fa-solid fa-clock-rotate-left me-1"></i> History
                </a>
            </div>

            <div class="col-8 mx-auto text-nowrap {{ Route::is('admin.settings*') ? 'text-light' : 'text-secondary' }}">
                <a href="{{ route('admin.settings') }}">
                    <i class="fa-solid fa-gear me-1"></i> Settings
                </a>
            </div>

            <div class="col-8 mx-auto text-nowrap text-danger"
                 onclick="event.preventDefault(); document.getElementById('logout').submit();">
                <a href="{{ route('logout') }}">
                    <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                </a>
            </div>


            <form method="POST" action="{{ route('logout') }}" id="logout" hidden="">
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // AREA CHART
            const areaCtx = document.getElementById('myAreaChart');
            if (areaCtx) {
                new Chart(areaCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{
                            label: 'Views',
                            data: [12, 19, 3, 5, 2, 3],
                            fill: true,
                            tension: 0.4
                        }]
                    }
                });
            }

            // BAR CHART
            const barCtx = document.getElementById('myBarChart');
            if (barCtx) {
                new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple'],
                        datasets: [{
                            label: 'Users',
                            data: [12, 19, 3, 5, 2]
                        }]
                    }
                });
            }

        });
    </script>

@endsection
