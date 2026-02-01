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

        <!-- Modal -->
        <div class="modal fade" id="addModeratorModal" tabindex="-1" aria-labelledby="addModeratorModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.users.makeModerator') }}" method="POST" id="spinnerForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModeratorModalLabel">Add New Moderator</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="form-control" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="spinnerBtn"><i class="fa-solid fa-add me-1"></i> Add Moderator <span id="spinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 mb-4">
            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                    data-bs-target="#addModeratorModal">
                <i class="fa-solid fa-plus me-1"></i> Add Moderator
            </button>
        </div>

        <div class="card">
            <div class="card-header text-capitalize">
                <i class="fa-solid fa-user me-1"></i> Users
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Email Verified</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th> <!-- Новая колонка -->
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                <span class="badge bg-{{ $user->type === 'admin' ? 'danger' : ($user->type === 'moderator' ? 'warning' : 'primary') }}">
                                    @if($user->type === 'admin')
                                        <i class="fa-solid fa-crown me-1"></i>
                                    @elseif($user->type === 'moderator')
                                        <i class="fa-solid fa-user-shield me-1"></i>
                                    @else
                                        <i class="fa-solid fa-user me-1"></i>
                                    @endif
                                    {{ ucfirst($user->type) }}
                                </span>
                                </td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="text-success">Yes</span>
                                    @else
                                        <span class="text-danger">No</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                                <td>{{ $user->updated_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    @if($user->type === 'moderator')
                                        <form action="{{ route('admin.users.removeModerator') }}" method="POST" class="d-inline">
                                            @csrf

                                            <input type="text" name="id" value="{{ $user->id }}" hidden="">

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa-solid fa-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <script>
            document.getElementById('spinnerForm')?.addEventListener('submit', function(e){
                const btn = document.getElementById('spinnerBtn');
                const spinner = document.getElementById('spinner');

                // Показываем спиннер
                spinner.classList.remove('d-none');

                // Блокируем кнопку, чтобы не нажали несколько раз
                btn.disabled = true;
            });
        </script>

@endsection
