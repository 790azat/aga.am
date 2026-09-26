@extends('layouts.admin')

@section('admin')
    <div class="container-fluid px-4">

        @include('layouts.admin-header')

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Add Film Button --}}
        <div class="col-12 mb-4">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addFilmModal" id="addFilmBtn">
                <i class="fa-solid fa-plus me-1"></i> Add Film
            </button>
        </div>

        {{-- ADD FILM MODAL --}}
        <div class="modal fade" id="addFilmModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filmModalTitle"><i class="fa-solid fa-plus me-1"></i> Add Film</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form method="POST" id="filmForm" action="{{ route('film.upload') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="modal-body">
                            <div class="row">
                                {{-- LEFT --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Film Name</label>
                                        <input type="text" name="name" id="filmName" class="form-control" required>
                                    </div>

                                    {{-- Main Category --}}
                                    <div class="mb-3">
                                        <label class="form-label">Main Category</label>
                                        <select name="category_id" id="filmCategory" class="form-select" required>
                                            <option value="" disabled selected>Select main category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Genres --}}
                                    <div class="mb-3">
                                        <label class="form-label">Genres</label>
                                        <div class="input-group mb-2">
                                            <select id="genreSelect" class="form-select">
                                                <option value="" disabled selected>Select genre</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-outline-success" onclick="addGenre()">Add</button>
                                        </div>
                                        <div id="selectedGenres" class="d-flex flex-wrap gap-2"></div>
                                    </div>

                                    {{-- Poster --}}
                                    <div class="mb-3">
                                        <label class="form-label">Poster</label>
                                        <input type="file" name="poster" class="form-control" accept="image/*" onchange="previewImage(this,'posterPreview')">
                                        <img loading="lazy" id="posterPreview" src="{{ asset('images/poster-placeholder.png') }}" class="img-fluid mt-2 rounded" style="max-height:220px">
                                    </div>

                                    {{-- Background --}}
                                    <div class="mb-3">
                                        <label class="form-label">Background Image</label>
                                        <input type="file" name="background" class="form-control" accept="image/*" onchange="previewImage(this,'backgroundPreview')">
                                        <img loading="lazy" id="backgroundPreview" class="img-fluid mt-2 rounded d-none" style="max-height:220px">
                                    </div>

                                    {{-- Logo --}}
                                    <div class="mb-3">
                                        <label class="form-label">Film Logo</label>
                                        <input type="file" name="logo" class="form-control" accept="image/*" onchange="previewImage(this,'logoPreview')">
                                        <img loading="lazy" id="logoPreview" src="{{ asset('images/logo-placeholder.png') }}" class="img-fluid mt-2 rounded" style="max-height:120px">
                                    </div>
                                </div>

                                {{-- RIGHT --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Video</label>
                                        <input type="file" name="video" class="form-control" accept="video/*" onchange="previewVideo(this,'videoPreview')">
                                        <video id="videoPreview" class="img-fluid mt-2 rounded d-none" style="max-height:220px" controls></video>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Release Year</label>
                                        <select name="year" id="filmYear" class="form-select">
                                            <option value="" disabled selected>Select year</option>
                                            @for($i = date('Y'); $i >= 1900; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Actors</label>
                                        <input type="text" name="actors" id="filmActors" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Director</label>
                                        <input type="text" name="director" id="filmDirector" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Producer</label>
                                        <input type="text" name="producer" id="filmProducer" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-success" type="submit" id="filmSubmitBtn"><i class="fa-solid fa-upload me-1"></i> Upload Film <span id="filmLoading" class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- EDIT FILM MODAL --}}
        <div class="modal fade" id="editFilmModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editFilmModalTitle"><i class="fa-solid fa-pen me-1"></i> Edit Film</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form method="POST" id="editFilmForm" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="_method" value="POST" id="editFilmMethod">

                        <div class="modal-body">
                            <div class="row">
                                {{-- LEFT --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Film Name</label>
                                        <input type="text" name="name" id="editFilmName" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Main Category</label>
                                        <select name="category_id" id="editFilmCategory" class="form-select" required>
                                            <option value="" disabled selected>Select main category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Genres</label>
                                        <div class="input-group mb-2">
                                            <select id="editGenreSelect" class="form-select">
                                                <option value="" disabled selected>Select genre</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-outline-success" onclick="addEditGenre()">Add</button>
                                        </div>
                                        <div id="editSelectedGenres" class="d-flex flex-wrap gap-2"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Poster</label>
                                        <input type="file" name="poster" class="form-control" accept="image/*" onchange="previewImage(this,'editPosterPreview')">
                                        <img loading="lazy" id="editPosterPreview" src="{{ asset('images/poster-placeholder.png') }}" class="img-fluid mt-2 rounded" style="max-height:220px">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Background Image</label>
                                        <input type="file" name="background" class="form-control" accept="image/*" onchange="previewImage(this,'editBackgroundPreview')">
                                        <img loading="lazy" id="editBackgroundPreview" class="img-fluid mt-2 rounded d-none" style="max-height:220px">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Film Logo</label>
                                        <input type="file" name="logo" class="form-control" accept="image/*" onchange="previewImage(this,'editLogoPreview')">
                                        <img loading="lazy" id="editLogoPreview" src="{{ asset('images/logo-placeholder.png') }}" class="img-fluid mt-2 rounded" style="max-height:120px">
                                    </div>
                                </div>

                                {{-- RIGHT --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Video</label>
                                        <input type="file" name="video" class="form-control" accept="video/*" onchange="previewVideo(this,'editVideoPreview')">
                                        <video id="editVideoPreview" class="img-fluid mt-2 rounded d-none" style="max-height:220px" controls></video>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Release Year</label>
                                        <select name="year" id="editFilmYear" class="form-select">
                                            <option value="" disabled selected>Select year</option>
                                            @for($i = date('Y'); $i >= 1900; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Actors</label>
                                        <input type="text" name="actors" id="editFilmActors" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Director</label>
                                        <input type="text" name="director" id="editFilmDirector" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Producer</label>
                                        <input type="text" name="producer" id="editFilmProducer" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-success" type="submit"><i class="fa-solid fa-save me-1"></i> Update Film <span id="filmLoading" class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- FILMS TABLE --}}
        <div class="card">
            <div class="card-body">
                <table class="table table-striped align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Poster</th>
                        <th>Logo</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Genres</th>
                        <th>Producer</th>
                        <th>Director</th>
                        <th>Actors</th>
                        <th>Background</th>
                        <th>Year</th>
                        <th>Video</th>
                        <th>Uploaded</th>
                        <th class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($films as $film)
                        <tr>
                            <td>{{ $film->id }}</td>
                            <td><img loading="lazy" src="{{ $film->poster ? storage_url($film->poster) : asset('images/poster-placeholder.png') }}" style="max-height:50px" class="rounded"></td>
                            <td>
                                @if($film->logo)
                                    <img loading="lazy" src="{{ storage_url($film->logo) }}" style="max-height:50px" class="rounded">
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $film->name }}</td>
                            <td><span class="badge bg-warning">{{ $film->category->name ?? '-' }}</span></td>
                            <td>
                                @forelse($film->genres as $genre)
                                    <span class="badge bg-success">{{ $genre->name }}</span>
                                @empty
                                    <span class="text-muted">—</span>
                                @endforelse
                            </td>
                            <td>{{ $film->producer ?: '—' }}</td>
                            <td>{{ $film->director ?: '—' }}</td>
                            <td>
                                {{ $film->actors?->pluck('name')->implode(', ') ?? 'No actors' }}
                            </td>
                            <td>
                                @if($film->background)
                                    <img loading="lazy" src="{{ storage_url($film->background) }}" style="max-height:40px" class="rounded">
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $film->year }}</td>
                            <td>
                                @if($film->video)
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#videoModal" data-video="{{ storage_url($film->video) }}">
                                        <i class="fa-solid fa-play"></i>
                                    </button>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-nowrap text-start">
                                <i class="fa-regular fa-calendar me-1"></i>{{ $film->created_at->format('d M Y') }}
                                <br>
                                <i class="fa-regular fa-clock me-1"></i>{{ $film->created_at->format('H:i') }}
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-warning editFilmBtn text-nowrap"
                                            data-id="{{ $film->id }}"
                                            data-name="{{ $film->name }}"
                                            data-poster="{{ $film->poster ? storage_url($film->poster) : '' }}"
                                            data-background="{{ $film->background ? storage_url($film->background) : '' }}"
                                            data-logo="{{ $film->logo ? storage_url($film->logo) : '' }}"
                                            data-video="{{ $film->video ? storage_url($film->video) : '' }}"
                                            data-category="{{ $film->category_id }}"
                                            data-genres="{{ $film->genres->pluck('id')->join(',') }}"
                                            data-producer="{{ $film->producer }}"
                                            data-director="{{ $film->director }}"
                                            data-actors="{{ $film->actors?->pluck('name')->implode(', ') ?? 'No actors' }}"
                                            data-year="{{ $film->year }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editFilmModal">
                                        <i class="fa-solid fa-pen me-1"></i> Edit
                                    </button>

                                    <button class="btn btn-sm btn-danger text-nowrap"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $film->id }}">
                                        <i class="fa-solid fa-trash-can me-1"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- VIDEO MODAL --}}
        <div class="modal fade" id="videoModal" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <video id="modalVideo" class="w-100" controls></video>
                    </div>
                </div>
            </div>
        </div>

        {{-- DELETE MODALS --}}
        @foreach($films as $film)
            <div class="modal fade" id="deleteModal{{ $film->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <form method="POST" action="{{ route('film.destroy', $film->id) }}">
                        @csrf
                        @method('DELETE')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    Are you sure you want to delete <strong>{{ $film->name }}</strong>?
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-4 text-center">
                                        <img loading="lazy" src="{{ $film->poster ? storage_url($film->poster) : asset('images/poster-placeholder.png') }}" class="img-fluid rounded mb-2" style="max-height:150px">
                                        @if($film->logo)
                                            <img loading="lazy" src="{{ storage_url($film->logo) }}" class="img-fluid rounded mb-2" style="max-height:80px">
                                        @else
                                            <span class="text-muted d-block mb-2">—</span>
                                        @endif
                                        @if($film->background)
                                            <img loading="lazy" src="{{ storage_url($film->background) }}" class="img-fluid rounded" style="max-height:80px">
                                        @else
                                            <span class="text-muted d-block">—</span>
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <p><strong>ID:</strong> {{ $film->id }}</p>
                                        <p><strong>Name:</strong> {{ $film->name }}</p>
                                        <p><strong>Category:</strong> {{ $film->category->name ?? '—' }}</p>
                                        <p><strong>Genres:</strong>
                                            @forelse($film->genres as $genre)
                                                <span class="badge bg-success me-1">{{ $genre->name }}</span>
                                            @empty
                                                <span class="text-muted">—</span>
                                            @endforelse
                                        </p>
                                        <p><strong>Producer:</strong> {{ $film->producer ?: '—' }}</p>
                                        <p><strong>Director:</strong> {{ $film->director ?: '—' }}</p>
                                        <p><strong>Actors:</strong> {{ $film->actors?->pluck('name')->implode(', ') ?? 'No actors' }}</p>
                                        <p><strong>Year:</strong> {{ $film->year ?: '—' }}</p>
                                        <p><strong>Video:</strong> {{ $film->video ? 'Yes' : '—' }}</p>
                                        <p><strong>Created at:</strong>
                                            <i class="fa-regular fa-calendar me-1"></i>{{ $film->created_at->format('d M Y') }}
                                            <i class="fa-regular fa-clock ms-2 me-1"></i>{{ $film->created_at->format('H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can me-1"></i> Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

    </div>

    <script>
        // ================= ADD =================
        function addGenre() {
            const select = document.getElementById('genreSelect');
            const container = document.getElementById('selectedGenres');
            const value = select.value;
            if (!value) return;
            const text = select.options[select.selectedIndex]?.text ?? value;
            if (container.querySelector('[data-value="' + value + '"]')) { select.value = ''; return; }
            const badge = document.createElement('span');
            badge.className = 'badge bg-success d-inline-flex align-items-center gap-2';
            badge.setAttribute('data-value', value);
            badge.innerHTML = `${text}<button type="button" class="btn btn-sm btn-light p-0 px-1" onclick="this.closest('span').remove()">&times;</button><input type="hidden" name="added_genres[]" value="${value}">`;
            container.appendChild(badge);
            select.value = '';
        }

        function previewImage(input, id) {
            const el = document.getElementById(id);
            if (input.files[0]) {
                el.src = URL.createObjectURL(input.files[0]);
                el.classList.remove('d-none');
            }
        }

        function previewVideo(input, id) {
            const el = document.getElementById(id);
            if (input.files[0]) {
                el.src = URL.createObjectURL(input.files[0]);
                el.classList.remove('d-none');
            }
        }

        document.getElementById('videoModal')?.addEventListener('show.bs.modal', e => {
            document.getElementById('modalVideo').src = e.relatedTarget.dataset.video;
        });

        // ================= EDIT =================
        function addEditGenre() {
            const select = document.getElementById('editGenreSelect');
            const container = document.getElementById('editSelectedGenres');
            const value = select.value;
            if (!value) return;
            const text = select.options[select.selectedIndex]?.text ?? value;
            if (container.querySelector('[data-value="' + value + '"]')) { select.value = ''; return; }
            const badge = document.createElement('span');
            badge.className = 'badge bg-success d-inline-flex align-items-center gap-2';
            badge.setAttribute('data-value', value);
            badge.innerHTML = `${text}<button type="button" class="btn btn-sm btn-light p-0 px-1" onclick="this.closest('span').remove()">&times;</button><input type="hidden" name="added_genres[]" value="${value}">`;
            container.appendChild(badge);
            select.value = '';
        }

        document.querySelectorAll('.editFilmBtn').forEach(btn => {
            btn.addEventListener('click', e => {
                const filmId = btn.dataset.id;
                const form = document.getElementById('editFilmForm');
                form.action = `/film/${filmId}`;

                // Устанавливаем метод PUT
                document.getElementById('editFilmMethod').value = 'PUT';



                // Fill fields
                document.getElementById('editFilmName').value = btn.dataset.name;
                document.getElementById('editFilmCategory').value = btn.dataset.category;
                document.getElementById('editFilmYear').value = btn.dataset.year;
                document.getElementById('editFilmActors').value = btn.dataset.actors;
                document.getElementById('editFilmDirector').value = btn.dataset.director;
                document.getElementById('editFilmProducer').value = btn.dataset.producer;

                // Clear genres
                document.getElementById('editSelectedGenres').innerHTML = '';
                if(btn.dataset.genres){
                    const genres = btn.dataset.genres.split(',');
                    genres.forEach(id => {
                        const select = document.getElementById('editGenreSelect');
                        const option = select.querySelector(`option[value="${id}"]`);
                        if(option){
                            select.value = id;
                            addEditGenre();
                        }
                    });
                }

                // MEDIA PREVIEW
                if(btn.dataset.poster){
                    const el = document.getElementById('editPosterPreview');
                    el.src = btn.dataset.poster;
                    el.classList.remove('d-none');
                }
                if(btn.dataset.background){
                    const el = document.getElementById('editBackgroundPreview');
                    el.src = btn.dataset.background;
                    el.classList.remove('d-none');
                }
                if(btn.dataset.logo){
                    const el = document.getElementById('editLogoPreview');
                    el.src = btn.dataset.logo;
                    el.classList.remove('d-none');
                }
                if(btn.dataset.video){
                    const el = document.getElementById('editVideoPreview');
                    el.src = btn.dataset.video;
                    el.classList.remove('d-none');
                }
            });
        });

        document.getElementById('editFilmForm')?.addEventListener('submit', function(e){
            const btn = document.getElementById('filmSubmitBtn');
            const spinner = document.getElementById('filmLoading');

            // Показываем спиннер
            spinner.classList.remove('d-none');

            // Блокируем кнопку, чтобы не нажали несколько раз
            btn.disabled = true;
        });

        document.getElementById('filmForm')?.addEventListener('submit', function(e){
            const btn = document.getElementById('filmSubmitBtn');
            const spinner = document.getElementById('filmLoading');

            // Показываем спиннер
            spinner.classList.remove('d-none');

            // Блокируем кнопку, чтобы не нажали несколько раз
            btn.disabled = true;
        });
    </script>
@endsection
