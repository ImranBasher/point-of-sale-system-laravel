@extends('admin.layout.main')

@section('content')
    <div class="container">
        @include('admin.role-permission.nav-link')
    </div>
    <div class="container-fluid">
        <h2>Permission Management</h2>

        <button id="openPermissionModalButton" class="btn btn-primary mb-3" data-action="add">Add Permission</button>

        <table class="table table-bordered">
            <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody id="permission-table-body">

            </tbody>
        </table>
    </div>
    @include('admin.role-permission.permission.modal.modal-permission')
@endsection

