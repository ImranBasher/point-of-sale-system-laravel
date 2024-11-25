@extends('admin.layout.main')

@section('content')
    <div class="container">
        @include('admin.role-permission.nav-link')
    </div>
    <div class="container-fluid">


        <h2>Role Management</h2>

        <button id="openRoleModalButton" class="btn btn-primary mb-3" data-action="add">Add Role</button>

        <table class="table table-bordered">
            <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody id="role-table-body">

            </tbody>
        </table>
    </div>
    @include('admin.role-permission.role.modal.modal-role')
@endsection

