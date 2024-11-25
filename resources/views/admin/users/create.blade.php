@extends('admin.layout.main')

@section('content')
@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif


@if(session('error'))
    <div class="alert alert-success">{{ session('error') }}</div>
@endif
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Create User
                        <a href="{{route('users.index')}}" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-header">
                    <form action="{{route('users.store')}}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>

                        <div class="form-group">
                            <label for="roles">Roles</label>

                            <select class="form-control" name="roles[]" required class="form-control"  multiple >
                                {{-- <option value="">Select Role</option> --}}

                                @foreach($roles as $role)
                                    <option value="{{ $role}}">{{ $role }}</option>
                                @endforeach

                            </select>

                        </div>

                        <button type="submit" class="btn btn-primary">Create User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
