@extends('admin.layout.main')

@section('content')
    <div class="container-fluid px-4">

        <!-- Card for Categories -->
        <div class="card mt-4 shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">
                    Brands
                    <button type="button" class="btn btn-primary float-end" id="openBrandModalButton">Add Brands</button>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr id="table-headers">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody id="brand-table-body">
                        <!-- Categories will be dynamically loaded here -->
                        </tbody>
                    </table>
                    <!-- Pagination Controls -->
                    <div id="pagination-controls">
                        <!-- Pagination links will be inserted here by JavaScript -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Modal for forms -->
        <div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBrandModalLabel">Add a Brand</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id = "main-modal-body">
                        <form id="addBrandForm"  method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Brand Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div>
                                <label for="brandDescription" class="form-label">Description:</label><br>
                                <textarea id="brandDescription" name="brandDescription" rows="4" cols = "50" class="form-control"></textarea><br>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" id="saveButton">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="editBrandModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBrandModalLabel">Edit Brand</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editBrandForm" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="edit-id" name="id">
                            <div class="mb-3">
                                <label for="edit-name" class="form-label">Brand Name</label>
                                <input type="text" class="form-control" id="edit-name" name="name" required>
                            </div>
                            <div>
                                <label for="brandDescription" class="form-label">Description:</label><br>
                                <textarea id="brandDescription" name="brandDescription" rows="4" cols = "50" class="form-control"></textarea><br>
                            </div>

                            <div class="mb-3">
                                <label for="edit-status" class="form-label">Status</label>
                                <select class="form-control" id="edit-status" name="status" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" id="updateButton">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
