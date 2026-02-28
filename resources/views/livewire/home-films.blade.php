<div>

    <livewire:search-films></livewire:search-films>

    <!-- HERO SECTION -->
    <div class="d-flex align-items-center"
         style="min-height:70vh;
                background:
                linear-gradient(to right, rgba(0,0,0,0.85), rgba(0,0,0,0.2)),
                url('{{ asset('images/main-poster.jpg') }}');
                background-size:cover;
                background-position:center;">

        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 text-light">

                    <div class="d-flex gap-3 align-items-center flex-wrap fw-bold small">
                        <span class="badge bg-warning">7.5+</span>
                        <span>•</span>
                        <span>2018</span>
                        <span>•</span>
                        <span>2 seasons</span>
                    </div>

                    <h1 class="fw-bold display-5 mt-3">
                        Lost in Space
                    </h1>

                    <p class="mt-3 text-secondary">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Adipisci aliquam dolorem ex explicabo illo itaque iure maxime.
                    </p>

                    <div class="d-flex gap-3 flex-wrap mt-4">
                        <button class="btn btn-danger rounded-pill px-4">
                            <i class="fa-solid fa-play me-2"></i> Watch now
                        </button>

                        <button class="btn btn-outline-light rounded-pill px-4">
                            <i class="fa-solid fa-square-plus me-2"></i> Add to playlist
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- TABS -->
    <div class="bg-black border-bottom border-secondary">
        <div class="container">
            <div class="row text-light text-center">

                <div class="col py-3 border-bottom border-danger border-3">
                    Trending now
                </div>

                <div class="col py-3 text-secondary">
                    Popular
                </div>

                <div class="col py-3 text-secondary">
                    Original
                </div>

                <div class="col py-3 text-secondary">
                    Premiers
                </div>

                <div class="col py-3 text-secondary">
                    Recently added
                </div>

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

                                <div style="height:260px; overflow:hidden; border-radius:10px;">
                                    <img
                                        src="{{ $film->poster ? asset('storage/'.$film->poster) : asset('images/poster-placeholder.png') }}"
                                        class="w-100 h-100"
                                        style="object-fit:cover;">
                                </div>

                                <div class="card-body p-2">

                                    <h6 class="fw-bold small mb-1 text-truncate">
                                        {{ $film->name }}
                                    </h6>

                                    <div class="d-flex justify-content-between small text-secondary">
                                        <span>{{ $film->year }}</span>
                                        <span class="text-warning">
                                            <i class="fa-solid fa-star"></i> 7.5
                                        </span>
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
