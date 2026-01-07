<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>AGA | Interactive Film Financing & Creative Platform</title>

        <link rel="shortcut icon" href="{{ asset('images/aga logo.png') }}" type="image/x-icon">

        <meta name="title" content="AGA | Interactive Film Financing & Creative Platform">
        <meta name="description" content="AGA is a digital platform where subscriptions act as votes for film funding. Watch vertical pilot reels, support creators, and become a co-producer. Presented by Andranik Abrahamyan.">
        <meta name="keywords" content="AGA platform, film financing, Andranik Abrahamyan, vertical video, creative industry, audience voting, movie production, co-producer, pilot reels, Armenian startup">
        <meta name="author" content="Andranik Abrahamyan">
        <meta name="robots" content="index, follow">

        <meta property="og:type" content="website">
        <meta property="og:url" content="https://aga.com/">
        <meta property="og:title" content="AGA - The Future of Creative Project Financing">
        <meta property="og:description" content="Discover and fund the next big film project. On AGA, creators showcase pilot reels and audiences vote for production funding via subscriptions.">
        <meta property="og:site_name" content="AGA">

        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="https://aga.com/">
        <meta property="twitter:title" content="AGA | Interactive Film Financing">
        <meta property="twitter:description" content="A participatory platform where your subscription funds the next big hit. Watch vertical pilots and vote for projects to be realized.">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="#000000">

</head>
<body style="background: #181818">

    <div class="col-12 container pt-5 d-flex justify-content-end">
        <div class="col-3 d-flex gap-3 justify-content-end">
            @auth
                <div>
                    <div class="btn btn-outline-light rounded rounded-pill px-3 py-2">
                        <a href="{{ route('dashboard') }}">
                            <p>{{ Auth::user()->name }} <i class="fa-solid fa-user ms-1"></i></p>
                        </a>
                    </div>
                </div>
            @else
                <div class="btn btn-outline-light rounded rounded-pill px-3 py-2">
                    <a href="{{ route('login') }}">
                        <p>Login <i class="fa-solid fa-user ms-1"></i></p>
                    </a>
                </div>
                <div class="btn btn-outline-light rounded rounded-pill px-3 py-2">
                    <a href="{{ route('register') }}">
                        <p>Register <i class="fa-solid fa-key ms-1"></i></p>
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <div class="col-12">
        <div class="container d-flex justify-content-center align-items-start pt-5">
            <div class="col-6">
                <div class="col-8 me-auto mt-5 d-flex justify-content-center align-items-end">
                    <img src="{{ asset('images/aga logo.png') }}" style="width: 200px" alt="">
                    <p class="text-light fw-bold" style="font-size: 100px">ga</p>
                </div>
                <div class="col-8 me-auto my-5 d-flex align-items-end">
                    <p class="text-light text-center" style="font-size: 30px">
                        AGA is an interactive digital platform for film and creative industry
                        professionals and emerging creators.
                    </p>
                </div>
                <div class="col-8 me-auto d-flex flex-wrap gap-3 mt-5">
                    <a href="/" class="col">
                        <img src="https://static-v1.mydramawave.com/frontend_static/assets/google-play-DFvvQRWM.webp" alt="" style="width: 100%">
                    </a>
                    <a href="/" class="col">
                        <img src="https://static-v1.mydramawave.com/frontend_static/assets/app-store-BVsC4YpI.webp" alt="" style="width: 100%">
                    </a>
                    <div class="col-12 d-flex justify-content-center">
                        <div class="col-8 mx-auto btn btn-outline-light rounded rounded-pill py-3 mt-3">
                            <a href="{{ route('dashboard') }}">
                                <p class="text-nowrap"><i class="fa-solid fa-globe me-2"></i> Browser version</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row row-cols-3">
                    @foreach($posters as $poster)
                        <div class="col mb-3">
                            <img src="{{ asset('images/' . $poster->img . '.webp') }}" class="rounded-3" style="width: 100%" alt="">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @include('components.layouts.app.footer')
</body>
</html>




