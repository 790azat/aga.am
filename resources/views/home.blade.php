@extends('layouts.app')

@section('content')

    <div class="col-12">
        <div class="col-12 d-flex"
             style="height: 500px;background-size: cover;background-position-y: center;background-image: url({{ asset('images/main-poster.jpg') }})">
            <div class="container d-flex justify-content-center align-items-center">
                <div class="col-6 text-light d-flex flex-column gap-4">
                    <div class="col-12 d-flex gap-3 text-center text-nowrap fw-bold">
                        <p class="badge bg-warning py-1 px-2" style="line-height: normal;">7.5 +</p>
                        <p><i class="fa-solid fa-circle" style="font-size: 10px"></i></p>
                        <p>2018</p>
                        <p><i class="fa-solid fa-circle" style="font-size: 10px"></i></p>
                        <p>2 seasons</p>
                    </div>
                    <div class="col-12 fw-bold">
                        <p style="font-size: 36px;line-height: 36px">Lost in space</p>
                    </div>
                    <div class="col-12 fw-bold">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci aliquam dolorem ex explicabo
                        illo itaque iure maxime, minus nam nemo nobis non odio praesentium quos recusandae sequi,
                        temporibus! Ex, totam.
                    </div>
                    <div class="col-12 d-flex gap-3">
                        <div class="btn btn-danger rounded-pill py-2 px-4">
                            <p><i class="fa-solid fa-play me-1"></i> Watch now</p>
                        </div>
                        <div class="btn btn-secondary rounded-pill py-2 px-4">
                            <p><i class="fa-solid fa-square-plus me-1"></i> Add to playlist</p>
                        </div>
                    </div>
                </div>
                <div class="col-6">

                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="container">
                <div class="col-12 d-flex gap-5 text-light text-center">
                    <div class="col px-3 py-4 border-bottom border-danger border-3">
                        <p>Trending now</p>
                    </div>
                    <div class="col px-3 py-4 border-danger border-3">
                        <p>Popular</p>
                    </div>
                    <div class="col px-3 py-4 border-danger border-3">
                        <p>Original</p>
                    </div>
                    <div class="col px-3 py-4 border-danger border-3">
                        <p>Premiers</p>
                    </div>
                    <div class="col px-3 py-4 border-danger border-3">
                        <p>Recently added</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 py-4" style="background: #1c1c1c">
            <div class="container">
                <div class="col-12 d-flex">
                    <div class="col">
                        <div class="col btn btn-danger rounded-pill py-2 px-5">
                            Action
                        </div>
                    </div>
                    <div class="col">
                        <div class="col btn btn-dark rounded-pill py-2 px-5">
                            Action
                        </div>
                    </div>
                    <div class="col">
                        <div class="col btn btn-dark rounded-pill py-2 px-5">
                            Action
                        </div>
                    </div>
                    <div class="col">
                        <div class="col btn btn-dark rounded-pill py-2 px-5">
                            Action
                        </div>
                    </div>
                    <div class="col">
                        <div class="col btn btn-dark rounded-pill py-2 px-5">
                            Action
                        </div>
                    </div>
                    <div class="col">
                        <div class="col btn btn-dark rounded-pill py-2 px-5">
                            Action
                        </div>
                    </div>
                    <div class="col">
                        <div class="col btn btn-dark rounded-pill py-2 px-5">
                            Action
                        </div>
                    </div>
                    <div class="col">
                        <div class="col btn btn-dark rounded-pill py-2 px-5">
                            Action
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 py-4">
            <div class="container">
                <div class="position-relative">

                    <!-- Left arrow -->
                    <button class="btn btn-dark slider-arrow start-0" onclick="slideLeft()">❮</button>

                    <!-- Slider -->
                    <div id="cardSlider" class="d-flex gap-3 overflow-hidden slider-track">
                        @foreach(collect($films)->take(12) as $film)
                            <a href="/film/{{ $film->id }}" class="slider-card d-flex flex-column"
                               style="width: 150px; margin: 0 10px;">
                                <div style="height: 280px; overflow: hidden; border-radius: 8px;">
                                    <img
                                        src="{{ $film->poster ? 'https://aga.am/public/storage/' . $film->poster : asset('images/poster-placeholder.png') }}"
                                        alt="{{ $film->name }}"
                                        style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                </div>
                                <div class="col-12 mt-3">
                                    <p class="text-light">
                                        {{ $film->name }}
                                    </p>
                                </div>

                                <div class="col-12 d-flex mt-1">
                                    <div class="col">
                                        <p class="text-secondary">{{ $film->year }}</p>
                                    </div>
                                    <div class="d-flex col-auto gap-2 me-3">
                                        <div class="col">
                                            <p class="text-danger"><i class="fa-solid fa-heart"></i></p>
                                        </div>
                                        <div class="col">
                                            <p class="text-danger"><i class="fa-solid fa-eye"></i></p>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <p class="text-warning"><i class="fa-solid fa-star me-1"></i> 7.5</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Right arrow -->
                    <button class="btn btn-dark slider-arrow end-0" onclick="slideRight()">❯</button>

                </div>
            </div>
        </div>


        <div class="col-12 mb-5">
            <div class="container">
                <div class="p-5 mb-4 bg-dark rounded-3 text-light">
                    <div class="container-fluid py-3">
                        <div>
                            <p class="text-light fw-bold" style="font-size: 25px">Aga <span class="fw-light" style="font-size: 20px">is an interactive digital platform designed for film and creative industry professionals as well as emerging creators. It serves as a hub for networking, collaboration, and discovering opportunities across all areas of filmmaking, including directing, producing, acting, screenwriting, and more. Whether you’re an established professional or just starting out, our platform provides the tools, resources, and community support to showcase your work, connect with peers, and grow your career.</span></p>
                        </div>
                        <button class="btn btn-warning btn-lg mt-3" type="button"><i class="fa-solid fa-star me-1"></i> Join as Talent</button>
                    </div>
                </div>
            </div>
        </div>

        @include('components.layouts.app.footer')


    </div>

    <script>
        const slider = document.getElementById('cardSlider');

        function slideRight() {
            slider.scrollLeft += slider.offsetWidth / 1.3;
        }

        function slideLeft() {
            slider.scrollLeft -= slider.offsetWidth / 1.3;
        }
    </script>

@endsection
