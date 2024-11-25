@extends('admin.layout.main')

@section('content')
    <div class="container">
        <h2>Units Management</h2>

        <!-- Button to Open the Add Unit Modal -->
        <button id="openUnitModalButton" class="btn btn-primary mb-3" data-action="add">Add Unit</button>

        <!-- Units Table -->
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Unit Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="unit-table-body">
            <!-- Data for units will be dynamically loaded here -->
            </tbody>
        </table>
    </div>

    @include('admin.units.modal.modal-unit') <!-- Ensure the correct modal file is included -->

@endsection
