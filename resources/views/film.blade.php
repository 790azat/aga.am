@extends('layouts.app')

@section('title', $film->name)
@section('description', \Illuminate\Support\Str::limit($film->description ?? $film->name, 155))

@section('content')

    @php
        $genres = $film->genres->pluck('name');
    @endphp

    <!-- HERO -->
    <section class="film-hero text-light"
             style="background-image: linear-gradient(to top, #181818 0%, rgba(24,24,24,.75) 45%, rgba(0,0,0,.35) 100%), url('{{ $film->background ? storage_url($film->background) : asset('images/background-placeholder.png') }}');">
        <div class="container py-5">
            <div class="row g-4 align-items-end">

                <div class="col-5 col-md-3">
                    <img src="{{ $film->poster ? storage_url($film->poster) : asset('images/poster-placeholder.png') }}"
                         class="w-100 rounded-3 shadow-lg film-hero-poster" alt="{{ $film->name }}">
                </div>

                <div class="col-12 col-md-9">
                    @if($film->logo)
                        <img src="{{ storage_url($film->logo) }}" class="mb-3" style="max-width:140px;max-height:70px" alt="">
                    @endif

                    <h1 class="fw-bold display-6 mb-2">{{ $film->name }}</h1>

                    <div class="d-flex flex-wrap align-items-center gap-2 small text-light opacity-75 mb-3">
                        @if($film->year)<span>{{ $film->year }}</span>@endif
                        @if($film->category)<span>•</span><span>{{ $film->category->name }}</span>@endif
                        @if($genres->isNotEmpty())<span>•</span><span>{{ $genres->join(', ') }}</span>@endif
                    </div>

                    @if($film->rating > 0)
                        <div class="d-flex align-items-center gap-1 mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                @php $stars = $film->rating / 2; @endphp
                                @if($stars >= $i)
                                    <i class="fa-solid fa-star text-warning"></i>
                                @elseif($stars >= $i - 0.5)
                                    <i class="fa-solid fa-star-half-stroke text-warning"></i>
                                @else
                                    <i class="fa-regular fa-star text-secondary"></i>
                                @endif
                            @endfor
                            <span class="fw-bold ms-2">{{ number_format($film->rating, 1) }}</span>
                        </div>
                    @endif

                    @if($film->description)
                        <p class="mb-4" style="max-width: 720px">{{ $film->description }}</p>
                    @endif

                    <div class="d-flex flex-wrap gap-2">
                        @if($film->video)
                            <button data-bs-toggle="modal" data-bs-target="#filmModal"
                                    class="btn btn-danger text-white rounded-pill px-4">
                                <i class="fa-solid fa-play me-1"></i> Watch trailer
                            </button>
                        @endif
                        <button type="button" class="btn btn-outline-light text-white rounded-pill px-4"
                                onclick="navigator.share ? navigator.share({title: @js($film->name), url: location.href}) : navigator.clipboard.writeText(location.href)">
                            <i class="fa-solid fa-share me-1"></i> Share
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @if($film->video)
        <div class="modal fade" id="filmModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content text-light" style="background-color: #181818">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title">{{ $film->name }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <video src="{{ storage_url($film->video) }}" controls preload="none" class="w-100 rounded"></video>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- DETAILS -->
    <div class="container text-light py-4">
        <div class="row g-5">

            <div class="col-12 col-lg-7">
                <div class="d-flex flex-wrap gap-4 mb-4 small">
                    @if($film->director)
                        <div><span class="text-secondary d-block">Director</span>{{ $film->director }}</div>
                    @endif
                    @if($film->producer)
                        <div><span class="text-secondary d-block">Producer</span>{{ $film->producer }}</div>
                    @endif
                </div>

                @if($film->actors->isNotEmpty())
                    <h2 class="h5 mb-3">Cast</h2>
                    <div class="d-flex gap-3 overflow-auto pb-2 mb-4">
                        @foreach($film->actors as $actor)
                            <a href="{{ route('actor.index', $actor->id) }}" class="text-center flex-shrink-0" style="width: 100px">
                                <div class="actor-avatar skeleton">
                                    <img src="{{ $actor->avatar ? storage_url($actor->avatar) : asset('images/actor-placeholder.png') }}"
                                         alt="{{ $actor->name }}" loading="lazy"
                                         onload="this.parentElement.classList.remove('skeleton')">
                                </div>
                                <p class="text-light mt-2 mb-0 text-truncate small">{{ $actor->name }}</p>
                            </a>
                        @endforeach
                    </div>
                @endif

                @if($relatedFilms->isNotEmpty())
                    <h2 class="h5 mb-3">More like {{ $film->name }}</h2>
                    <div class="d-flex gap-3 overflow-auto pb-2">
                        @foreach($relatedFilms as $related)
                            <a href="/film/{{ $related->id }}" class="related-card flex-shrink-0" style="width:120px">
                                <div class="related-poster skeleton">
                                    <img src="{{ $related->poster ? storage_url($related->poster) : asset('images/poster-placeholder.png') }}"
                                         alt="{{ $related->name }}" loading="lazy"
                                         onload="this.parentElement.classList.remove('skeleton')">
                                </div>
                                <p class="text-light mt-2 mb-0 text-truncate small">{{ $related->name }}</p>
                                <p class="text-secondary small">{{ $related->year }}</p>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="col-12 col-lg-5">
                <h2 class="h5 mb-3">Trailer</h2>
                @if($film->video)
                    <video src="{{ storage_url($film->video) }}" controls preload="metadata" class="w-100 rounded-3"></video>
                @else
                    <p class="text-secondary">No trailer available.</p>
                @endif
            </div>

        </div>
    </div>


    <livewire:comments-section :film-id="$film->id"/>


    @include('components.layouts.app.footer')

@endsection


