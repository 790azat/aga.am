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


        <div class="col-12 mb-4">
            <div class="btn btn-success" data-bs-toggle="modal" data-bs-target="#categoryModal">
                <i class="fa-solid fa-plus me-1"></i> Add Category
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="categoryModalLabel">
                            <i class="fa-solid fa-plus me-1"></i> Add Category
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <form id="categoryForm" method="POST" action="{{ route('category.store') }}">
                            @csrf
                            <input type="hidden" name="_method" value="POST" id="categoryFormMethod">
                            <input type="hidden" name="category_id" id="categoryId">

                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" form="categoryForm" class="btn btn-success">Save Category</button>
                    </div>

                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card mb-4">
            <div class="card-header text-capitalize">
                <i class="fas fa-table me-1"></i>
                Categories
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <th scope="row">{{ $category->id }}</th>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td class="text-end">

                                <button type="button"
                                        class="btn btn-sm btn-warning me-1 edit-category-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#categoryModal"
                                        data-id="{{ $category->id }}"
                                        data-name="{{ $category->name }}"
                                        data-slug="{{ $category->slug }}">
                                    <i class="fa-solid fa-pen me-1"></i> Edit
                                </button>

                                <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa-solid fa-trash-can me-1"></i> Delete
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No categories found
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categoryModal = document.getElementById('categoryModal');
            const categoryForm = document.getElementById('categoryForm');
            const methodInput = document.getElementById('categoryFormMethod');
            const categoryIdInput = document.getElementById('categoryId');

            categoryModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                if (button.classList.contains('edit-category-btn')) {
                    const id = button.dataset.id;
                    const name = button.dataset.name;
                    const slug = button.dataset.slug;

                    categoryForm.action = `/admin/categories/${id}`; // PUT /categories/{id}
                    methodInput.value = 'PUT';
                    categoryIdInput.value = id;

                    categoryForm.querySelector('input[name="name"]').value = name;
                    categoryForm.querySelector('input[name="slug"]').value = slug;

                    categoryModal.querySelector('.modal-title').innerHTML =
                        '<i class="fa-solid fa-pen me-1"></i> Edit Category';
                    categoryModal.querySelector('[type="submit"]').textContent = 'Update Category';
                } else {
                    categoryForm.action = "{{ route('category.store') }}";
                    methodInput.value = 'POST';
                    categoryIdInput.value = '';

                    categoryForm.reset();
                    categoryModal.querySelector('.modal-title').innerHTML =
                        '<i class="fa-solid fa-plus me-1"></i> Add Category';
                    categoryModal.querySelector('[type="submit"]').textContent = 'Save Category';
                }
            });
        });
    </script>
@endsection
