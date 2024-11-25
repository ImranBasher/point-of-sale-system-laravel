@extends('admin.layout.main')

@section('content')
    <div class="container">
        <h2>Category Management</h2>

        <!-- Button to Open the Add Category Modal -->
        <button id="openCategoryModalButton" class="btn btn-primary mb-3" data-action="add">Add Category</button>

        <!-- Categories Table -->
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Parent Category</th>
                <th>Position No</th>
                <th>Thumbnail</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Updated By</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="category-table-body">

            </tbody>
        </table>
    </div>

    @include('admin.categories.modal.modal-category') <!-- Ensure the correct modal file is included -->


@endsection
