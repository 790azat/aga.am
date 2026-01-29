@extends('layouts.app')

@section('content')

    @php
        // Предположим, что контроллер передал фильм как $film
        // Если нужно, можно передать еще коллекцию похожих фильмов в $relatedFilms
    @endphp

    <div class="col-12 mb-5">
        <div class="col-12 d-flex"
             style="background-image: url('{{ $film->background ? asset('public/storage/' . $film->background) : asset('public/storage/backgrounds/background-placeholder.png') }}');background-size: cover;height: 500px">
            <div class="col-9 mx-auto d-flex">

                <!-- Левая колонка: кнопки, рейтинг -->
                <div class="col-6 d-flex flex-column justify-content-end gap-3">
                    <div class="col-12 mb-3">
                        <div style="width: 200px" class="rounded-2 overflow-hidden">
                            <img src="{{ $film->poster ? asset('public/storage/' . $film->poster) : asset('images/poster-placeholder.png') }}" style="width: 100%;height: 100%" alt="">
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-start align-items-center gap-3">
                        <a href="{{ $film->video ? asset('public/storage/videos/' . $film->video) : '#' }}"
                           class="btn btn-danger rounded-pill my-2 px-4 text-light">
                            <i class="fa-solid fa-play me-1"></i> Watch
                        </a>
                        <div class="btn btn-dark rounded-pill my-2 px-4">
                            <i class="fa-solid fa-plus me-1"></i> Add to my playlist
                        </div>

                        <div class="col-auto d-flex gap-2">
                            @for($i=1;$i<=5;$i++)
                                <div class="col">
                                    <i class="fa-solid fa-star {{ $i <= floor($film->rating ?? 3) ? 'text-warning' : 'text-secondary' }}"></i>
                                </div>
                            @endfor
                        </div>
                        <div class="col-auto">
                            <p class="text-light fw-bold">{{ $film->rating ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-start align-items-center gap-3 text-light ms-3 mb-3">
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

                <!-- Правая колонка: название, описание, детали -->
                <div class="col-6 text-light d-flex flex-column gap-4 justify-content-center">
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <div style="width: 100px">
                            <img src="{{ $film->logo ? asset('public/storage/' . $film->logo) : asset('images/logo-placeholder.png') }}" style="width: 100%" alt="{{ $film->name }}">
                        </div>
                    </div>
                    <div class="col-12 text-nowrap">
                        <p>
                            {{ $film->year ?? 'N/A' }}
                            <span style="font-size: 8px"><i class="fa-solid fa-circle"></i></span>
                            R
                            <span style="font-size: 8px"><i class="fa-solid fa-circle"></i></span>
                            2h 44m <!-- можно заменить на $film->duration если есть -->
                            <span style="font-size: 8px"><i class="fa-solid fa-circle"></i></span>
                            {{ $film->main_genre ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="col-12">
                        <p>{{ $film->description ?? 'No description available.' }}</p>
                    </div>
                    <div class="col-12 d-flex text-nowrap">
                        <div class="col-auto border-end pe-5">
                            <div class="col-12"><i class="fa-solid fa-user-tie me-1"></i><span class="fw-bold">Director:</span> {{ $film->director ?? 'N/A' }}</div>
                            @if($film->actors)
                                @foreach(explode(',', $film->actors) as $actor)
                                    <div class="col-12"><i class="fa-solid fa-masks-theater me-1"></i> {{ trim($actor) }}</div>
                                @endforeach
                            @endif
                        </div>
                        <div class="col ps-5">
                            <div class="col-12"><i class="fa-solid fa-calendar me-1"></i> {{ $film->year ?? 'N/A' }}</div>
                            <div class="col-12"><i class="fa-solid fa-circle-nodes me-1"></i> {{ $film->main_genre ?? 'N/A' }}</div>
                            <div class="col-12"><i class="fa-solid fa-icons me-1"></i> {{ $film->genres ?? 'N/A' }}</div>
                        </div>
                        <div class="col-6"></div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Навигация вкладок -->
        <div class="col-12 mt-2" style="border-bottom: 1px solid #393939">
            <div class="col-9 mx-auto d-flex gap-5 fw-bold">
                <div class="col-auto px-3 py-2 border-bottom border-3 border-danger text-light"><p>OVERVIEW</p></div>
                <div class="col-auto px-3 py-2 border-danger text-secondary"><p>TRAILERS & MORE</p></div>
                <div class="col-auto px-3 py-2 border-danger text-secondary"><p>MORE LIKE THIS</p></div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <div class="col-9 mx-auto d-flex text-light gap-5">

                <!-- Левая колонка: Cast & Crew -->
                <div class="col-7">
                    <div class="col-12 mb-3"><p>Cast & Crew</p></div>
                    <div class="col-12 d-flex justify-content-start gap-3">
                        @if($film->actors)
                            @foreach(explode(',', $film->actors) as $actor)
                                <div class="col text-center">
                                    <div style="background-image: url('{{ asset('images/actor-placeholder.png') }}');width: 100px;height: 100px;background-size: cover;background-position: center; border-radius: 8px;"></div>
                                    <p class="text-light mt-2">{{ trim($actor) }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="col-12 mt-4">
                        <div class="col-12 mb-3"><p>More Like {{ $film->name }}</p></div>
                        <div class="col-12 py-2 d-flex gap-3 overflow-auto">
                            @if(isset($relatedFilms))
                                @foreach($relatedFilms as $related)
                                    <a href="{{ route('film.show', $related->id) }}" class="col d-flex flex-column" style="min-width:120px;">
                                        <div style="height: 100px; overflow: hidden; border-radius: 8px;">
                                            <img src="{{ $related->poster ? asset('public/storage/posters/' . $related->poster) : asset('images/poster-placeholder.png') }}" alt="{{ $related->name }}" style="width:100%; height:100%; object-fit:cover;">
                                        </div>
                                        <p class="text-light mt-2">{{ $related->name }}</p>
                                        <p class="text-secondary">{{ $related->year }}</p>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Правая колонка: Trailer & Clips -->
                <div class="col d-flex flex-column gap-3">
                    <div class="col-12 mb-3"><p>Trailer & Clips</p></div>
                    @if($film->video)
                        <div class="col-12 mb-3">
                            <video src="{{ asset('public/storage/videos/' . $film->video) }}" controls style="width:100%; height:auto; border-radius:8px;"></video>
                        </div>
                    @else
                        <p class="text-secondary">No trailer available.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

    @include('components.layouts.app.footer')

@endsection
