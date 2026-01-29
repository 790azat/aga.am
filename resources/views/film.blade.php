@extends('layouts.app')

@section('content')

    <div class="col-12 mb-5">
        <div class="col-12 d-flex"
             style="background-image: url('{{ asset('images/blade poster.jpg') }}');background-size: cover;height: 500px">
            <div class="col-9 mx-auto d-flex">
                <div class="col-6 d-flex flex-column justify-content-end pb-5 gap-3">
                    <div class="col-12 d-flex justify-content-start align-items-center gap-3">
                        <div class="btn btn-danger rounded-pill my-2 px-4" >
                            <i class="fa-solid fa-play me-1"></i> Watch
                        </div>
                        <div class="btn btn-dark rounded-pill my-2 px-4">
                            <i class="fa-solid fa-plus me-1"></i> Add to my playlist
                        </div>
                        <div class="col-auto d-flex gap-2">
                            <div class="col"><i class="fa-solid fa-star text-warning"></i></div>
                            <div class="col"><i class="fa-solid fa-star text-warning"></i></div>
                            <div class="col"><i class="fa-solid fa-star text-warning"></i></div>
                            <div class="col"><i class="fa-solid fa-star text-warning"></i></div>
                            <div class="col"><i class="fa-solid fa-star text-secondary"></i></div>
                        </div>
                        <div class="col-auto">
                            <p class="text-light fw-bold">8.0</p>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-start align-items-center gap-3 text-light ms-3">
                        <div class="col-auto">
                            <p><i class="fa-solid fa-thumbs-up me-1"></i> Like</p>
                        </div>
                        <div class="vr"></div>
                        <div class="col-auto">
                            <p><i class="fa-solid fa-share me-1"></i> Share</p>
                        </div>
                        <div class="vr"></div>
                        <div class="col-auto">
                            <p><i class="fa-solid fa-download me-1"></i> Download</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 text-light d-flex flex-column gap-4 justify-content-center">
                    <div class="col-12">
                        <img src="{{ asset('images/blade-logo.png') }}" style="width: 100%" alt="">
                    </div>
                    <div class="col-12 text-nowrap">
                        <p>2017 <span style="font-size: 8px"><i class="fa-solid fa-circle"></i></span> R <span
                                style="font-size: 8px"><i class="fa-solid fa-circle"></i></span> 2h 44m <span
                                style="font-size: 8px"><i class="fa-solid fa-circle"></i></span> Sci-fi</p>
                    </div>
                    <div class="col-12">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, aliquam aperiam asperiores ex
                            excepturi in incidunt inventore ipsam itaaque iusto laudantium libero, magnam non officia
                            optio perferendis quia rem rerum</p>
                    </div>
                    <div class="col-12 d-flex text-nowrap">
                        <div class="col-auto border-end pe-5">
                            <div class="col-12"><i class="fa-solid fa-user-tie me-1"></i><span
                                    class="fw-bold">Director:</span> Denis Villeneuve
                            </div>
                            <div class="col-12"><i class="fa-solid fa-masks-theater me-1"></i> Ryan Gosling</div>
                            <div class="col-12"><i class="fa-solid fa-masks-theater me-1"></i> Ana de Armas</div>
                            <div class="col-12"><i class="fa-solid fa-masks-theater me-1"></i> Jared Leto</div>
                        </div>
                        <div class="col ps-5">
                            <div class="col-12"><i class="fa-solid fa-calendar me-1"></i> RR</div>
                            <div class="col-12"><i class="fa-solid fa-clock me-1"></i> 2017</div>
                            <div class="col-12"><i class="fa-solid fa-circle-nodes me-1"></i> Sci-fi</div>
                            <div class="col-12"><i class="fa-solid fa-icons me-1"></i> Sci-fi, Action, Fantastic</div>
                        </div>
                        <div class="col-6"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-2" style="border-bottom: 1px solid #393939">
            <div class="col-9 mx-auto d-flex gap-5 fw-bold">
                <div class="col-auto px-3 py-2 border-bottom border-3 border-danger text-light">
                    <p>OVERVIEW</p>
                </div>
                <div class="col-auto px-3 py-2 border-danger text-secondary">
                    <p>TRAILERS & MORE</p>
                </div>
                <div class="col-auto px-3 py-2 border-danger text-secondary">
                    <p>MORE LIKE THIS</p>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <div class="col-9 mx-auto d-flex text-light gap-5">
                <div class="col-7">
                    <div class="col-12 mb-3">
                        <p>Cast & Crew</p>
                    </div>
                    <div class="col-12 d-flex justify-content-start gap-3">
                        @for($i = 1;$i <= 6; $i++)
                            <div class="col">
                                <div class="col-12 mb-2">
                                    <div style="background-image: url('{{ asset('images/actor ' . '(' . $i . ').jfif') }}');width: 100px;height: 100px;background-size: cover;background-position: center"></div>
                                </div>
                                <divl class="col-12 text-nowrap">
                                    <p>Ryan Gosling</p>
                                </divl>
                            </div>
                        @endfor
                    </div>
                    <div class="col-12 mt-4">
                        <div class="col-12 mb-3">
                            <p>More Like Blade Runner 2049</p>
                        </div>
                        <div class="col-12 py-2">

                            <!-- Slider -->
                            <div class="d-flex gap-3 overflow-hidden">
                                @foreach(collect($films)->take(4) as $film)
                                    <a href="/film/1" class="col d-flex flex-column">
                                        <div style="height: 100px; overflow: hidden; border-radius: 8px;">
                                            <img
                                                src="{{ Str::contains($film['posterUrlPreview'], 'no-poster.png') ? asset('images/poster-placeholder.png') : $film['posterUrlPreview'] }}"
                                                alt="{{ $film['nameRu'] ?? 'Poster' }}"
                                                style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <p class="text-light">
                                                {{ $film['nameRu'] ?? 'No title available' }}
                                            </p>
                                        </div>

                                        <div class="col-12 d-flex mt-1">
                                            <divl class="col">
                                                <p class="text-secondary">{{ $film['year'] }}</p>
                                            </divl>
                                            <div class="col-auto">
                                                <p class="text-warning"><i
                                                        class="fa-solid fa-star me-1"></i> {{ $film['ratingKinopoisk'] }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col d-flex flex-column gap-3">
                    <div class="col-12 mb-3">
                        <p>Trailer & Clips</p>
                    </div>
                    <div class="col-12 d-flex justify-content-start gap-3">
                        <div
                            class="col-12 border-bottom border-2 border-danger rounded rounded-3 overflow-hidden d-flex justify-content-center align-items-center"
                            style="background-image: url('{{ asset('images/trailer.avif') }}');background-size: cover;height: 200px">
                            <div
                                class="border border-2 border-danger rounded rounded-circle p-2 d-flex justify-content-center align-items-center"
                                style="width: 40px; height: 40px;background: rgba(0,0,0,0.5)">
                                <i class="fa-solid fa-play"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex gap-3">
                        <div class="col d-flex justify-content-start gap-3">
                            <div
                                class="col-12 border-bottom border-2 border-danger rounded rounded-3 overflow-hidden d-flex justify-content-center align-items-center"
                                style="background-image: url('{{ asset('images/trailer.jpg') }}');background-size: cover;height: 150px">
                                <div
                                    class="border border-2 border-danger rounded rounded-circle p-2 d-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px;background: rgba(0,0,0,0.5)">
                                    <i class="fa-solid fa-play"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col d-flex justify-content-start gap-3">
                            <div
                                class="col-12 border-bottom border-2 border-danger rounded rounded-3 overflow-hidden d-flex justify-content-center align-items-center"
                                style="background-image: url('{{ asset('images/trailer3.webp') }}');background-size: cover;height: 150px">
                                <div
                                    class="border border-2 border-danger rounded rounded-circle p-2 d-flex justify-content-center align-items-center"
                                    style="width: 40px; height: 40px;background: rgba(0,0,0,0.5)">
                                    <i class="fa-solid fa-play"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.layouts.app.footer')

@endsection
