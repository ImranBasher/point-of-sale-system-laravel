@extends('admin.layout.main')

@section('content')
    <div class="container-fluid">
        <h2>Product Management</h2>

        <!-- Button to Open the Add Product Modal -->
        <button id="openProductModalButton" class="btn btn-primary mb-3" data-action="add">Add Product</button>

        <!-- Products Table -->
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Thumbnail</th>
                <th>Title</th>
                <th>SLUG</th>
                <th>SKU</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Short Description</th>
                <th>Long Description</th>
                <th>Status</th>
                <th>Images</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="product-table-body">
            <!-- Product rows will be appended here by JavaScript -->
            </tbody>
        </table>
    </div>
    @include('admin.products.modal.modal-product')
@endsection

