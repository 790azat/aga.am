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
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                <span
                                    class="badge bg-{{ $user->type === 'admin' ? 'danger' : ($user->type === 'moderator' ? 'warning' : 'primary') }}">
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
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

@endsection
