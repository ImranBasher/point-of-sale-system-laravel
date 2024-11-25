@extends('admin.layout.main')

@section('content')
    <div class="container">
        <h2>Origins Management</h2>

        <!-- Button to Open the Add Origin Modal -->
        <button id="openOriginModalButton" class="btn btn-primary mb-3" data-action="add">Add Origin</button>

        <!-- Origins Table -->
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Origin Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="origin-table-body">
            <!-- Data for origins will be dynamically loaded here -->
            </tbody>
        </table>
    </div>

    @include('admin.origins.modal.modal-origin') <!-- Ensure the correct modal file is included -->

@endsection
