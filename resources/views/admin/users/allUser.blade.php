@extends('admin.layout.main')

@section('content')
    <div class="container">
        @include('admin.role-permission.nav-link')
    </div>
    <div class="container">
        <h2>User Management</h2>

        <!-- Button to Open the Add Customer Modal -->
{{--        <button id="openUserModalButton" class="btn btn-primary mb-3" data-action="add">Add User</button>--}}

        <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
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
            <tbody id="user-table-body">
                @php $i = 1 @endphp
                @foreach($users as $user)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
{{--                        <td>{{$user->role}}</td>--}}
                        <!-- <td>${user.status}</td> -->
                        <td>
                            @if(!empty($user->getRoleNames()))
                                @foreach ($user->getRoleNames() as $rolename )
                                    <label class="badge bg-primary mx-1" >{{ $rolename}}</label>
                                @endforeach
                            @endif
                        </td>
                        <td>
{{--                            <a href="#" class="editUserButton btn btn-warning" data-id="{{$user->id}}">Edit</a>--}}
                            <!-- <a href="#" class="deleteUserButton btn btn-warning" data-id="${user.id}">Delete</a> -->
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                            </form>
                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>
    </div>

    {{--    @include('admin.customers.modal.modal-customer') <!-- Ensure the correct modal file is included -->--}}

@endsection
