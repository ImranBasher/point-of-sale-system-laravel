@extends('admin.layout.main')

@section('content')
    <div class="container">
        <h2>Customer Management</h2>

        <!-- Button to Open the Add Customer Modal -->
        <button id="openCustomerModalButton" class="btn btn-primary mb-3" data-action="add">Add Customer</button>

        <!-- Customers Table -->
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody id="customer-table-body">
            <!-- Customer data will be dynamically populated here -->
            </tbody>
        </table>
    </div>

{{--    @include('admin.customers.modal.modal-customer') <!-- Ensure the correct modal file is included -->--}}

@endsection
