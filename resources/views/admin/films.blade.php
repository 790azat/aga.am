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
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addFilmModal">
                <i class="fa-solid fa-plus me-1"></i> Add Film
            </button>
        </div>

        {{-- Add / Edit Film Modal --}}
        <div class="modal fade" id="addFilmModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fa-solid fa-plus me-1"></i> Add Film
                        </h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form method="POST" action="{{ route('film.upload') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="modal-body">
                            <div class="row">

                                {{-- LEFT --}}
                                <div class="col-md-6">

                                    <div class="mb-3">
                                        <label class="form-label">Film Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>

                                    {{-- Main Category --}}
                                    <div class="mb-3">
                                        <label class="form-label">Main Category</label>
                                        <select name="category_id" class="form-select" required>
                                            <option value="" disabled selected>Select main category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Genres (BADGES) --}}
                                    <div class="mb-3">
                                        <label class="form-label">Genres</label>

                                        <div class="input-group mb-2">
                                            <select id="genreSelect" class="form-select">
                                                <option value="" disabled selected>Select genre</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-outline-success" onclick="addGenre()">
                                                Add
                                            </button>
                                        </div>

                                        <div id="selectedGenres" class="d-flex flex-wrap gap-2"></div>
                                    </div>

                                    {{-- Poster --}}
                                    <div class="mb-3">
                                        <label class="form-label">Poster</label>
                                        <input type="file" name="poster" class="form-control" accept="image/*"
                                               onchange="previewImage(this,'posterPreview')">
                                        <img id="posterPreview"
                                             src="{{ asset('images/poster-placeholder.png') }}"
                                             class="img-fluid mt-2 rounded"
                                             style="max-height:220px">
                                    </div>

                                    {{-- Background --}}
                                    <div class="mb-3">
                                        <label class="form-label">Background Image</label>
                                        <input type="file" name="background" class="form-control" accept="image/*"
                                               onchange="previewImage(this,'backgroundPreview')">
                                        <img id="backgroundPreview"
                                             class="img-fluid mt-2 rounded d-none"
                                             style="max-height:220px">
                                    </div>

                                    {{-- Logo --}}
                                    <div class="mb-3">
                                        <label class="form-label">Film Logo</label>
                                        <input type="file" name="logo" class="form-control" accept="image/*"
                                               onchange="previewImage(this,'logoPreview')">
                                        <img id="logoPreview"
                                             src="{{ asset('images/logo-placeholder.png') }}"
                                             class="img-fluid mt-2 rounded"
                                             style="max-height:120px">
                                    </div>
                                </div>

                                {{-- RIGHT --}}
                                <div class="col-md-6">

                                    <div class="mb-3">
                                        <label class="form-label">Video</label>
                                        <input type="file" name="video" class="form-control" accept="video/*"
                                               onchange="previewVideo(this,'videoPreview')">
                                        <video id="videoPreview"
                                               class="img-fluid mt-2 rounded d-none"
                                               style="max-height:220px"
                                               controls></video>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Release Year</label>
                                        <select name="year" class="form-select">
                                            <option value="" disabled selected>Select year</option>
                                            @for($i = date('Y'); $i >= 1900; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Actors</label>
                                        <input type="text" name="actors" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Director</label>
                                        <input type="text" name="director" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Producer</label>
                                        <input type="text" name="producer" class="form-control">
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-success" type="submit">Save Film</button>
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

                            <td>
                                <img
                                    src="{{ $film->poster ? asset('storage/'.$film->poster) : asset('images/poster-placeholder.png') }}"
                                    style="max-height:50px"
                                    class="rounded">
                            </td>

                            <td>
                                @if($film->logo)
                                    <img src="{{ asset('storage/'.$film->logo) }}"
                                         style="max-height:50px"
                                         class="rounded">
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td>{{ $film->name }}</td>

                            <td>
                <span class="badge bg-warning">
                    {{ $film->category->name ?? '-' }}
                </span>
                            </td>

                            <td>
                                @forelse($film->genres as $genre)
                                    <span class="badge bg-success">{{ $genre->name }}</span>
                                @empty
                                    <span class="text-muted">—</span>
                                @endforelse
                            </td>

                            <td>{{ $film->producer ?: '—' }}</td>
                            <td>{{ $film->director ?: '—' }}</td>
                            <td>{{ $film->actors ?: '—' }}</td>

                            <td>
                                @if($film->background)
                                    <img src="{{ asset('storage/'.$film->background) }}"
                                         style="max-height:40px"
                                         class="rounded">
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td>{{ $film->year }}</td>

                            <td>
                                @if($film->video)
                                    <button class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#videoModal"
                                            data-video="{{ asset('storage/'.$film->video) }}">
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
                                <button class="btn btn-sm btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $film->id }}"
                                        data-id="{{ $film->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
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

    {{-- DELETE MODAL --}}
    @foreach($films as $film)
        <div class="modal fade" id="deleteModal{{ $film->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <form method="POST" action="{{ route('films.destroy', $film->id) }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-4 text-center">
                                    {{-- Poster --}}
                                    <img src="{{ $film->poster ? asset('storage/'.$film->poster) : asset('images/poster-placeholder.png') }}"
                                         class="img-fluid rounded mb-2" style="max-height:150px">

                                    {{-- Logo --}}
                                    @if($film->logo)
                                        <img src="{{ asset('storage/'.$film->logo) }}" class="img-fluid rounded mb-2" style="max-height:80px">
                                    @else
                                        <span class="text-muted d-block mb-2">—</span>
                                    @endif

                                    {{-- Background --}}
                                    @if($film->background)
                                        <img src="{{ asset('storage/'.$film->background) }}" class="img-fluid rounded" style="max-height:80px">
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
                                    <p><strong>Actors:</strong> {{ $film->actors ?: '—' }}</p>
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
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach


    <script>

        function addGenre() {
            const select = document.getElementById('genreSelect');
            const container = document.getElementById('selectedGenres');

            const value = select.value;
            if (!value) return;

            const text = select.options[select.selectedIndex]?.text ?? value;

            // не добавлять дубликаты
            if (container.querySelector('[data-value="' + value + '"]')) {
                select.value = '';
                return;
            }

            const badge = document.createElement('span');
            badge.className = 'badge bg-success d-inline-flex align-items-center gap-2';
            badge.setAttribute('data-value', value);

            badge.innerHTML = `
        ${text}
        <button type="button"
                class="btn btn-sm btn-light p-0 px-1"
                onclick="this.closest('span').remove()">
            &times;
        </button>
        <input type="hidden" name="categories[]" value="${value}">
    `;

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

        document.getElementById('videoModal')
            ?.addEventListener('show.bs.modal', e => {
                document.getElementById('modalVideo').src = e.relatedTarget.dataset.video;
            });

        document.getElementById('deleteModal')
            ?.addEventListener('show.bs.modal', e => {
                document.getElementById('deleteForm').action = '/films/' + e.relatedTarget.dataset.id;
            });
    </script>
@endsection
