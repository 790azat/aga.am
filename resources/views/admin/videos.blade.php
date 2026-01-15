@extends('layouts.admin')

@section('admin')
    <div class="container-fluid px-4">

        @include('layouts.admin-header')

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
                        <th>Title</th>
                        <th>Name</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($videos as $video)
                        <tr>
                            <th scope="row">{{ $video->id }}</th>
                            <td>{{ $video->title }}</td>
                            <td>{{ $video->name }}</td>
                            <td>{{ $video->created_at->format('d.m.Y') }}</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-warning me-1">
                                    <i class="fa-solid fa-pen me-1"></i> Edit
                                </button>

                                <button type="button" class="btn btn-sm btn-danger">
                                    <i class="fa-solid fa-trash-can me-1"></i> Delete
                                </button>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                No videos found
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>

    </div>
@endsection
