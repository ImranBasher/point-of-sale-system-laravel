@extends('admin.layout.main')

@section('content')
    <div class="container">
        <h2>Customer Management</h2>

        <!-- Button to Open the Add Customer Modal -->
{{--        <button id="openUserModalButton" class="btn btn-primary mb-3" data-action="add">Add Admin</button>--}}


{{--        <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>--}}

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
            <tbody id="admin-table-body">

            </tbody>
        </table>
    </div>

{{--        @include('admin.users.modal.modal-user') <!-- Ensure the correct modal file is included -->--}}

@endsection
