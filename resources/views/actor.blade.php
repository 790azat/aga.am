@extends('layouts.app')

@section('content')

    <div class="col-12 mb-5">
        <div class="col-12 d-flex"
             style="background-image: url('{{ asset('images/background-placeholder.png') }}'); background-size: cover; height: 500px;">
            <div class="col-9 mx-auto d-flex">

                <!-- Left column: actor photo and name -->
                <div class="col-6 d-flex flex-column justify-content-end gap-3">
                    <div class="col-12">
                        <div style="width: 200px" class="rounded-2 overflow-hidden">
                            <img src="{{ $actor->avatar ? asset('public/storage/' . $actor->avatar) : asset('images/actor-placeholder.png') }}"
                                 style="width: 100%; height: 100%;" alt="{{ $actor->name }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="text-light fw-bold fs-4">{{ $actor->name }}</p>
                    </div>
                </div>

                <!-- Right column: biography -->
                <div class="col-6 text-light d-flex flex-column gap-4 justify-content-center">
                    <div class="col-12">
                        <h5>Biography</h5>
                        <p>{{ $actor->bio ?? 'Biography not available.' }}</p>
                    </div>
                    <div class="col-12">
                        <h5>Known For</h5>
                        <div class="col-12 d-flex gap-3 overflow-auto">
                            @if(!empty($actor->films))
                                @foreach($actor->films as $film)
                                    <a href="/film/{{ $film->id }}" class="col d-flex flex-column related-card" style="max-width:120px">
                                        <div class="related-poster skeleton">
                                            <img src="{{ $film->poster ? asset('public/storage/' . $film->poster) : asset('images/poster-placeholder.png') }}"
                                                 alt="{{ $film->name }}"
                                                 loading="lazy"
                                                 onload="this.parentElement.classList.remove('skeleton')">
                                        </div>
                                        <p class="text-light mt-2 text-nowrap mb-0">{{ $film->name }}</p>
                                        <p class="text-secondary small">{{ $film->year ?? 'N/A' }}</p>
                                    </a>
                                @endforeach
                            @else
                                <p class="text-light">No films available.</p>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Tabs -->
        <div class="col-12 mt-2" style="border-bottom: 1px solid #393939">
            <div class="col-9 mx-auto d-flex gap-5 fw-bold">
                <div class="col-auto px-3 py-2 border-bottom border-3 border-danger text-light"><p>OVERVIEW</p></div>
                <div class="col-auto px-3 py-2 border-danger text-secondary"><p>FILMS</p></div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <div class="col-9 mx-auto d-flex flex-wrap gap-3">
                @if(!empty($actor->films))
                    @foreach($actor->films as $film)
                        <a href="/film/{{ $film->id }}" class="col-auto d-flex flex-column related-card" style="max-width:150px;">
                            <div class="related-poster skeleton">
                                <img src="{{ $film->poster ? asset('public/storage/' . $film->poster) : asset('images/poster-placeholder.png') }}"
                                     alt="{{ $film->name }}"
                                     loading="lazy"
                                     onload="this.parentElement.classList.remove('skeleton')">
                            </div>
                            <p class="text-light mt-2 text-nowrap mb-0">{{ $film->name }}</p>
                            <p class="text-secondary small">{{ $film->year ?? 'N/A' }}</p>
                        </a>
                    @endforeach
                @else
                    <p class="text-light">No films available.</p>
                @endif
            </div>
        </div>
    </div>

    @include('components.layouts.app.footer')

@endsection
