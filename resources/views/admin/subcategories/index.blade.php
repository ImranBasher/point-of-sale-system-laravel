@extends('admin.layout.main')

@section('content')
    <div class="container">
        <h2>Product Management</h2>

        <!-- Button to Open the Add Product Modal -->
        <button id="openSubcategoryModalButton" class="btn btn-primary mb-3" data-action="add">Add Subcategory</button>

        <!-- Products Table -->
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Position No</th>
                <th>Thumbnail</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Updated By</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="subcategory-table-body">
            <!-- Product rows will be appended here by JavaScript -->
            </tbody>
        </table>
    </div>

    <!-- Include Modals -->
    @include('admin.subcategories.modal.modal-subcategory')
    {{-- @include('admin.products.js-product') --}}

{{--    @if($errors->any())--}}
{{--        <div class="card-footer text-body-secondary">--}}
{{--            <div class="alert alert-danger">--}}
{{--                <ul>--}}
{{--                    @foreach ($errors->all() as $error)--}}
{{--                        <li>{{ $error }}</li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}

    {{-- @push('scripts') --}}
    {{-- <script src="{{ asset('js/product.js') }}"></script> <!-- Ensure to create a product.js file for the script --> --}}
    {{-- @endpush --}}
@endsection

