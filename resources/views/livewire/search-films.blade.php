<div>
    <div class="col-2 mx-auto d-flex justify-content-center align-items-center">
        <div class="dropdown w-100">
            <div class="input-group">
        <span class="input-group-text">
            <i class="fa fa-search"></i>
        </span>
                <input
                    type="text"
                    class="form-control dropdown-toggle"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    wire:model.live="search"
                    placeholder="Search films..."
                />
            </div>

            @if($showDropdown)
                <ul class="dropdown-menu w-100 show">
                    @forelse($films as $film)
                        <li>
                            <a href="film/{{ $film->id }}">
                                <button class="dropdown-item" type="button">
                                    <div class="col-12 d-flex align-items-center gap-3">
                                        <div class="col-auto" style="width: 50px;height: 70px">
                                            <img src="{{ asset('public/storage/' . $film->poster) }}" alt="" style="width: 100%;height: 100%;object-fit: cover">
                                        </div>
                                        <divl class="col-auto">
                                            <p class="fs-5 fw-bold">{{ $film->name }}</p>
                                        </divl>
                                    </div>
                                </button>
                            </a>
                        </li>
                    @empty
                        <li>
                            <span class="dropdown-item text-muted">No results</span>
                        </li>
                    @endforelse
                </ul>
            @endif
        </div>
    </div>
</div>
