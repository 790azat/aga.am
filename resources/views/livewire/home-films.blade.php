<div>

    <livewire:search-films></livewire:search-films>

    <!-- HERO SECTION -->
    @php
        $heroBg = $featured?->background ? storage_url($featured->background) : asset('images/main-poster.webp');
    @endphp
    <div class="d-flex align-items-center"
         style="min-height:70vh;
                background:
                linear-gradient(to right, rgba(0,0,0,0.9), rgba(0,0,0,0.2)),
                url('{{ $heroBg }}');
                background-size:cover;
                background-position:center;">

        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 text-light">

                    @if($featured)
                        <div class="d-flex gap-3 align-items-center flex-wrap fw-bold small">
                            @if($featured->rating > 0)
                                <span class="badge bg-warning text-dark"><i class="fa-solid fa-star me-1"></i>{{ number_format($featured->rating, 1) }}</span>
                            @endif
                            @if($featured->year)
                                <span>{{ $featured->year }}</span>
                            @endif
                            @if($featured->category)
                                <span>•</span>
                                <span>{{ $featured->category->name }}</span>
                            @endif
                        </div>

                        <h1 class="fw-bold display-5 mt-3">{{ $featured->name }}</h1>

                        @if($featured->description)
                            <p class="mt-3 text-light opacity-75">{{ \Illuminate\Support\Str::limit($featured->description, 220) }}</p>
                        @endif

                        <div class="d-flex gap-3 flex-wrap mt-4">
                            <a href="{{ url('/film/'.$featured->id) }}" class="btn btn-danger rounded-pill px-4">
                                <i class="fa-solid fa-play me-2"></i> Watch now
                            </a>
                        </div>
                    @else
                        <h1 class="fw-bold display-5">Aga</h1>
                        <p class="mt-3 text-light opacity-75">Films will appear here soon.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>


    <!-- TABS -->
    <div class="bg-black border-bottom border-secondary">
        <div class="container">
            <div class="row text-center g-0">
                @foreach(['trending' => 'Trending now', 'popular' => 'Popular', 'recent' => 'Recently added'] as $key => $label)
                    <button type="button"
                            wire:click="selectTab('{{ $key }}')"
                            class="col py-3 btn btn-link text-decoration-none rounded-0 border-0 {{ $tab === $key ? 'text-light border-bottom border-danger border-3' : 'text-secondary' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>


    <!-- CATEGORY FILTER -->
    <div class="py-4" style="background:#1c1c1c;">
        <div class="container">
            <div class="d-flex gap-3 flex-wrap">

                <button
                    wire:click="selectCategory(null)"
                    class="btn {{ $selectedCategoryId == null ? 'btn-danger' : 'btn-dark' }} rounded-pill px-4 text-nowrap">
                    All
                </button>

                @foreach($categories as $category)
                    <button
                        wire:click="selectCategory({{ $category->id }})"
                        class="btn {{ $selectedCategoryId == $category->id ? 'btn-danger' : 'btn-dark' }} rounded-pill px-4 text-nowrap">
                        {{ $category->name }}
                    </button>
                @endforeach

            </div>
        </div>
    </div>


    <!-- FILMS GRID (NO HORIZONTAL SCROLL) -->
    <div class="py-5">
        <div class="container">

            <div class="row g-4">

                @foreach($films as $film)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">

                        <a href="/film/{{ $film->id }}"
                           class="text-decoration-none">

                            <div class="card bg-dark border-0 text-light h-100">

                                <div class="film-card-poster">
                                    <img
                                        src="{{ $film->poster ? storage_url($film->poster) : asset('images/poster-placeholder.png') }}"
                                        alt="{{ $film->name }}"
                                        loading="lazy"
                                        decoding="async"
                                        class="w-100 h-100"
                                        style="object-fit:cover;">
                                </div>

                                <div class="card-body p-2">

                                    <h6 class="fw-bold small mb-1 text-truncate">
                                        {{ $film->name }}
                                    </h6>

                                    <div class="d-flex justify-content-between small text-secondary">
                                        <span>{{ $film->year }}</span>
                                        @if($film->rating > 0)
                                            <span class="text-warning">
                                                <i class="fa-solid fa-star"></i> {{ number_format($film->rating, 1) }}
                                            </span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                        </a>

                    </div>
                @endforeach

            </div>

        </div>
    </div>


    <!-- INFO BLOCK -->
    <div class="pb-5">
        <div class="container">
            <div class="p-4 p-md-5 bg-dark rounded-4 text-light">

                <h4 class="fw-bold">
                    Aga
                    <span class="fw-light fs-6">
                        is an interactive digital platform designed for film and creative industry
                        professionals as well as emerging creators.
                    </span>
                </h4>

                <button class="btn btn-warning mt-4 rounded-pill px-4">
                    <i class="fa-solid fa-star me-2"></i> Join as Talent
                </button>

            </div>
        </div>
    </div>

    @include('components.layouts.app.footer')

</div>
