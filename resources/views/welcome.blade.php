<!doctype html>
<html lang="en">
<head>

    <!-- Google tag -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-WCHDCGSMLQ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-WCHDCGSMLQ');
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>AGA | Interactive Film Financing & Creative Platform</title>
    <meta name="description" content="AGA is an interactive digital platform for film and creative industry professionals and emerging creators.">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">

    <link rel="icon" href="{{ asset('images/favicon-64.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/aga-logo.png') }}">

</head>

<body style="background:#181818;">

<!-- TOP BAR -->
<div class="container pt-4">
    <div class="d-flex justify-content-end flex-wrap gap-2 text-light">

        @auth
            <a href="{{ route('home') }}"
               class="btn btn-outline-light rounded-pill d-flex align-items-center gap-2 px-3 py-2">
                <img src="{{ storage_url(Auth::user()->avatar) }}"
                     style="width:30px;height:30px;object-fit:cover;border-radius:50%" alt="">
                <span class="text-light">{{ Auth::user()->name }}</span>
            </a>
        @else
            <a href="{{ route('login') }}"
               class="btn btn-outline-light rounded-pill px-3">
                Login <i class="fa-solid fa-user ms-1"></i>
            </a>

            <a href="{{ route('register') }}"
               class="btn btn-outline-light rounded-pill px-3">
                Register <i class="fa-solid fa-key ms-1"></i>
            </a>
        @endauth

    </div>
</div>


<!-- MAIN SECTION -->
<div class="container py-5">
    <div class="row align-items-center">

        <!-- LEFT SIDE -->
        <div class="col-12 col-lg-6 text-center text-lg-start mb-5 mb-lg-0">

            <!-- LOGO -->
            <div class="d-flex justify-content-center align-items-end">
                <img src="{{ asset('images/aga-logo.webp') }}"
                     class="img-fluid"
                     style="max-width:120px"
                     alt="AGA logo">
                <span class="text-light fw-bold display-1 ms-2">ga</span>
            </div>

            <!-- DESCRIPTION -->
            <p class="text-light fs-4 mt-4">
                AGA is an interactive digital platform for film and creative industry
                professionals and emerging creators.
            </p>

            <!-- STORE BUTTONS -->
            <div class="d-flex flex-column flex-sm-row col-8 mx-auto gap-3 mt-4 justify-content-center justify-content-lg-start">
                {{-- Свои кнопки вместо картинок, взятых с чужого сайта --}}
                <a href="/" class="flex-fill btn btn-outline-light text-white rounded-3 py-2 d-flex align-items-center justify-content-center gap-2">
                    <i class="fa-brands fa-google-play fs-4"></i>
                    <span class="text-start lh-sm"><small class="d-block opacity-75">GET IT ON</small>Google Play</span>
                </a>
                <a href="/" class="flex-fill btn btn-outline-light text-white rounded-3 py-2 d-flex align-items-center justify-content-center gap-2">
                    <i class="fa-brands fa-apple fs-4"></i>
                    <span class="text-start lh-sm"><small class="d-block opacity-75">Download on the</small>App Store</span>
                </a>
            </div>

            <!-- BROWSER BUTTON -->
            <div class="mt-4 text-center">
                <a href="{{ route('home') }}"
                   class="btn btn-outline-light rounded-pill px-4 py-3 text-light">
                    <i class="fa-solid fa-globe me-2"></i> Browser version
                </a>
            </div>

            <!-- USERS COUNTER -->
            <div class="d-flex justify-content-center align-items-center text-light mt-4">
                <span>Active users</span>
                <i class="fa-solid fa-users mx-2"></i>
                <span class="counter"
                      data-target="{{ 1000 + \Illuminate\Support\Carbon::now()->dayOfYear }}"></span>
            </div>

        </div>


        <!-- RIGHT SIDE (POSTERS GRID) -->
        <div class="col-12 col-lg-6">
            <div class="row row-cols-2 row-cols-sm-3 g-3">
                @foreach($posters as $poster)
                    <div class="col">
                        <img src="{{ storage_url($poster) }}"
                             class="img-fluid rounded-3"
                             style="object-fit:cover"
                             alt="Poster">
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>


<!-- COUNTER SCRIPT -->
<script>
    const counters = document.querySelectorAll(".counter");

    counters.forEach(counter => {
        counter.innerText = "0";

        const updateCounter = () => {
            const target = +counter.getAttribute("data-target");
            const current = +counter.innerText.replace(/,/g,'');

            const increment = target / 200;

            if (current < target) {
                counter.innerText = Math.ceil(current + increment).toLocaleString();
                setTimeout(updateCounter, 10);
            } else {
                counter.innerText = target.toLocaleString();
            }
        };

        updateCounter();
    });
</script>

@include('components.layouts.app.footer')

</body>
</html>
