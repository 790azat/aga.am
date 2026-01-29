@extends('layouts.admin')

@section('admin')
    <div class="container-fluid px-4">

        @include('layouts.admin-header')

        <div class="col-12 mb-4">
            <div class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa-solid fa-plus me-1"></i> Add film
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl"> <!-- делаем модал большего размера -->
                <div class="modal-content">

                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                            <i class="fa-solid fa-plus me-1"></i> Add Film
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <form id="filmUploadForm" method="POST" action="{{ route('film.upload') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <!-- Левая колонка -->
                                <div class="col-md-6">

                                    <!-- Film Name -->
                                    <div class="mb-3">
                                        <label class="form-label">Film Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>

                                    <!-- Main Genre -->
                                    <div class="mb-3">
                                        <label class="form-label">Main Genre</label>
                                        <select name="main_genre" class="form-select" required>
                                            <option value="" selected disabled>Select main genre</option>
                                            <option value="action">Action</option>
                                            <option value="drama">Drama</option>
                                            <option value="sci-fi">Sci-Fi</option>
                                            <option value="comedy">Comedy</option>
                                            <option value="horror">Horror</option>
                                        </select>
                                    </div>

                                    <!-- Genres -->
                                    <div class="mb-3">
                                        <label class="form-label">Genres</label>
                                        <div class="input-group mb-2">
                                            <select id="genreSelect" class="form-select">
                                                <option value="" selected disabled>Select genre</option>
                                                <option value="action">Action</option>
                                                <option value="drama">Drama</option>
                                                <option value="sci-fi">Sci-Fi</option>
                                                <option value="comedy">Comedy</option>
                                                <option value="horror">Horror</option>
                                                <option value="thriller">Thriller</option>
                                                <option value="romance">Romance</option>
                                            </select>
                                            <button type="button" class="btn btn-outline-success" onclick="addGenre()">Add</button>
                                        </div>
                                        <div id="selectedGenres" class="d-flex flex-wrap gap-2"></div>
                                    </div>

                                    <!-- Poster -->
                                    <div class="mb-3">
                                        <label class="form-label">Poster</label>
                                        <input type="file" name="poster" class="form-control" accept="image/*"
                                               onchange="previewImage(this, 'posterPreview')">
                                        <img id="posterPreview"
                                             class="img-fluid mt-2 rounded"
                                             style="max-height: 220px;"
                                             src="{{ old('poster', isset($film) && $film->poster ? 'https://aga.am/public/storage/posters/' . $film->poster : asset('images/poster-placeholder.png')) }}">
                                    </div>

                                    <!-- Background -->
                                    <div class="mb-3">
                                        <label class="form-label">Background Image</label>
                                        <input type="file" name="background" class="form-control" accept="image/*"
                                               onchange="previewImage(this, 'backgroundPreview')">
                                        <img id="backgroundPreview"
                                             class="img-fluid mt-2 rounded d-none"
                                             style="max-height: 220px;">
                                    </div>

                                    <!-- Logo -->
                                    <div class="mb-3">
                                        <label class="form-label">Film Logo</label>
                                        <input type="file" name="logo" class="form-control" accept="image/*"
                                               onchange="previewImage(this, 'logoPreview')">
                                        <img id="logoPreview"
                                             class="img-fluid mt-2 rounded"
                                             style="max-height: 120px;"
                                             src="{{ asset('images/logo-placeholder.png') }}">
                                    </div>

                                </div>

                                <!-- Правая колонка -->
                                <div class="col-md-6">

                                    <!-- Video -->
                                    <div class="mb-3">
                                        <label class="form-label">Video File</label>
                                        <input type="file" name="video" class="form-control" accept="video/*"
                                               onchange="previewVideo(this, 'videoPreview')">
                                        <video id="videoPreview"
                                               class="img-fluid mt-2 rounded d-none"
                                               style="max-height: 220px;"
                                               controls></video>
                                    </div>

                                    <!-- Year -->
                                    <div class="mb-3">
                                        <label class="form-label">Release Year</label>
                                        <select name="year" class="form-select">
                                            <option value="" selected disabled>Select year</option>
                                            @for ($i = date('Y'); $i >= 1900; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <!-- Actors -->
                                    <div class="mb-3">
                                        <label class="form-label">Actors</label>
                                        <input type="text" name="actors" class="form-control" placeholder="Actor 1, Actor 2, Actor 3">
                                    </div>

                                    <!-- Director -->
                                    <div class="mb-3">
                                        <label class="form-label">Director</label>
                                        <input type="text" name="director" class="form-control">
                                    </div>

                                    <!-- Producer -->
                                    <div class="mb-3">
                                        <label class="form-label">Producer</label>
                                        <input type="text" name="producer" class="form-control">
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" form="filmUploadForm" class="btn btn-success">Upload Film</button>
                    </div>

                </div>
            </div>
        </div>


        {{-- TABLE --}}
        <div class="card mb-4">
            <div class="card-header text-capitalize">
                <i class="fas fa-table me-1"></i>
                {{ request()->segment(2) }}
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Poster</th>
                        <th>Logo</th>
                        <th>Title</th>
                        <th>Main Genre</th>
                        <th>Year</th>
                        <th>Video</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($films as $film)
                        <tr>
                            <th scope="row">{{ $film->id }}</th>

                            <!-- Poster -->
                            <td>
                                <img src="{{ $film->poster ? 'https://aga.am/public/storage/' . $film->poster : asset('images/poster-placeholder.png') }}"
                                     alt="Poster" class="img-fluid rounded" style="max-height: 60px;">
                            </td>

                            <td>
                                <img src="{{ $film->logo ? 'https://aga.am/public/storage/' . $film->logo : asset('images/logo-placeholder.png') }}"
                                     alt="Logo" class="img-fluid rounded" style="max-height: 60px;">
                            </td>


                            <td>{{ $film->name }}</td>
                            <td>{{ $film->main_genre }}</td>
                            <td>{{ $film->year }}</td>

                            <!-- Video preview -->
                            <td>
                                @if($film->video)
                                    <video src="https://aga.am/public/storage/{{ $film->video }}"
                                           style="max-height: 60px;" controls></video>
                                @else
                                    <span class="text-muted">No video</span>
                                @endif
                            </td>

                            <td>
                                <i class="fa-solid fa-calendar-days me-1"></i>
                                {{ $film->created_at->format('d M Y') }}
                                <i class="fa-solid fa-clock ms-2 me-1"></i>
                                {{ $film->created_at->format('H:i:s') }}
                            </td>

                            <!-- Actions -->
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-warning me-1">
                                    <i class="fa-solid fa-pen me-1"></i> Edit
                                </button>

                                <button type="button"
                                        class="btn btn-sm btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#filmInfoModal"
                                        data-id="{{ $film->id }}"
                                        data-name="{{ $film->name }}"
                                        data-main_genre="{{ $film->main_genre }}"
                                        data-genres="{{ $film->genres }}"
                                        data-year="{{ $film->year }}"
                                        data-actors="{{ $film->actors }}"
                                        data-director="{{ $film->director }}"
                                        data-producer="{{ $film->producer }}"
                                        data-poster="{{ $film->poster ? 'https://aga.am/public/storage/' . $film->poster : asset('images/poster-placeholder.png') }}"
                                        data-logo="{{ $film->logo ? 'https://aga.am/public/storage/' . $film->logo : asset('images/logo-placeholder.png') }}"
                                        data-video="{{ $film->video ? 'https://aga.am/public/storage/' . $film->video : '' }}"
                                        data-created="{{ $film->created_at->format('d M Y H:i:s') }}">
                                    <i class="fa-solid fa-trash-can me-1"></i> Delete
                                </button>

                                <div class="modal fade" id="filmInfoModal" tabindex="-1" aria-labelledby="filmInfoModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title" id="filmInfoModalLabel">Film Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="row g-3">
                                                    <div class="col-md-4 text-center">
                                                        <img id="modalPoster" src="" alt="Poster" class="img-fluid rounded mb-2">
                                                        <img id="modalLogo" src="" alt="Logo" class="img-fluid rounded mb-2">
                                                        <video id="modalVideo" src="" controls class="img-fluid d-none"></video>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item"><strong>Name:</strong> <span id="modalName"></span></li>
                                                            <li class="list-group-item"><strong>Main Genre:</strong> <span id="modalMainGenre"></span></li>
                                                            <li class="list-group-item"><strong>Genres:</strong> <span id="modalGenres"></span></li>
                                                            <li class="list-group-item"><strong>Year:</strong> <span id="modalYear"></span></li>
                                                            <li class="list-group-item"><strong>Actors:</strong> <span id="modalActors"></span></li>
                                                            <li class="list-group-item"><strong>Director:</strong> <span id="modalDirector"></span></li>
                                                            <li class="list-group-item"><strong>Producer:</strong> <span id="modalProducer"></span></li>
                                                            <li class="list-group-item"><strong>Created:</strong> <span id="modalCreated"></span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <form id="deleteFilmForm" method="POST" action="">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                No films found
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>


            </div>
        </div>

    </div>



    <script>
        const filmModal = document.getElementById('filmInfoModal');

        filmModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const main_genre = button.getAttribute('data-main_genre');
            const genres = button.getAttribute('data-genres');
            const year = button.getAttribute('data-year');
            const actors = button.getAttribute('data-actors');
            const director = button.getAttribute('data-director');
            const producer = button.getAttribute('data-producer');
            const poster = button.getAttribute('data-poster');
            const logo = button.getAttribute('data-logo');
            const video = button.getAttribute('data-video');
            const created = button.getAttribute('data-created');

            // Заполняем поля модала
            document.getElementById('modalName').textContent = name;
            document.getElementById('modalMainGenre').textContent = main_genre;
            document.getElementById('modalGenres').textContent = genres;
            document.getElementById('modalYear').textContent = year;
            document.getElementById('modalActors').textContent = actors;
            document.getElementById('modalDirector').textContent = director;
            document.getElementById('modalProducer').textContent = producer;
            document.getElementById('modalCreated').textContent = created;

            // Poster
            document.getElementById('modalPoster').src = poster;

            // Logo
            document.getElementById('modalLogo').src = logo;

            // Video
            const modalVideo = document.getElementById('modalVideo');
            if (video) {
                modalVideo.src = video;
                modalVideo.classList.remove('d-none');
            } else {
                modalVideo.classList.add('d-none');
                modalVideo.src = '';
            }

            // Устанавливаем форму удаления
            const deleteForm = document.getElementById('deleteFilmForm');
            deleteForm.action = `/films/${id}`; // предполагаем маршрут DELETE /films/{id}
        });

    </script>
    <script>
        <!-- JS для превью изображений/видео -->
        function previewImage(input, previewId, placeholder = null) {
            const preview = document.getElementById(previewId);
            if (!preview) return;

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = placeholder || "{{ asset('images/poster-placeholder.png') }}";
                preview.classList.remove('d-none');
            }
        }

        function previewVideo(input, previewId) {
            const preview = document.getElementById(previewId);
            if (!preview) return;

            if (input.files && input.files[0]) {
                const url = URL.createObjectURL(input.files[0]);
                preview.src = url;
                preview.classList.remove('d-none');
            } else {
                preview.src = '';
                preview.classList.add('d-none');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {

            /* ================= MODAL RESET ================= */
            const modal = document.getElementById('exampleModal');
            const form = document.getElementById('filmUploadForm');

            if (modal && form) {
                modal.addEventListener('hidden.bs.modal', function () {
                    form.reset();

                    // clear genres
                    const genresContainer = document.getElementById('selectedGenres');
                    if (genresContainer) genresContainer.innerHTML = '';

                    // clear image/video previews
                    ['posterPreview', 'backgroundPreview', 'logoPreview', 'videoPreview'].forEach(id => {
                        const el = document.getElementById(id);
                        if (!el) return;

                        if (el.tagName === 'IMG') {
                            if (id === 'posterPreview') el.src = "{{ asset('images/poster-placeholder.png') }}";
                            else if (id === 'logoPreview') el.src = "{{ asset('images/logo-placeholder.png') }}";
                            else el.src = '';
                        } else if (el.tagName === 'VIDEO') {
                            el.src = '';
                            el.load();
                        }

                        el.classList.add('d-none');
                    });
                });
            }

            /* ================= GENRES TAGS ================= */
            window.addGenre = function () {
                const select = document.getElementById('genreSelect');
                const container = document.getElementById('selectedGenres');
                if (!select || !container) return;

                const value = select.value;
                const text = select.options[select.selectedIndex]?.text;
                if (!value) return;

                if (container.querySelector(`[data-value="${value}"]`)) {
                    select.value = '';
                    return;
                }

                const badge = document.createElement('span');
                badge.className = 'badge bg-success d-flex align-items-center gap-2';
                badge.dataset.value = value;
                badge.innerHTML = `
                ${text}
                <button type="button" class="btn btn-sm btn-light p-0 px-1"
                        onclick="this.parentElement.remove()">&times;</button>
                <input type="hidden" name="genres[]" value="${value}">
            `;
                container.appendChild(badge);
                select.value = '';
            };

            /* ================= YEAR DROPDOWN ================= */
            const yearSelect = document.querySelector('select[name="year"]');
            const currentYear = new Date().getFullYear();
            if (yearSelect) {
                for (let y = currentYear; y >= 1900; y--) {
                    const option = document.createElement('option');
                    option.value = y;
                    option.textContent = y;
                    yearSelect.appendChild(option);
                }
            }

        });
    </script>


@endsection
