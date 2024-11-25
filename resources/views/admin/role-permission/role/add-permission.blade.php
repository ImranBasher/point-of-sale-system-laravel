@extends('admin.layout.main')

@section('content')

    <div class="container-fluid">
{{--        @error('status')--}}
{{--        <span class="taxt-success">{{$message}}</span>--}}
{{--        @enderror--}}
        {{-- @dd($rolePermissions) --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Role : {{$role->name}}
                            <a href="{{route('roles.index')}}" class="btn btn-danger float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-header">
                        <form action="{{route('roles.give-permission', $role->id)}}" method="POST">
                            @csrf
                            @method('PUT')

                            @error('error')
                                <span class="taxt-danger">{{$message}}</span>
                            @enderror

                            <label> Permission </label>
                            <div class="row">
                                @foreach ( $permissions as $permission )
                                    <div class="col-md-2">
                                        <label >
                                            <input type="checkbox" name="permission[]" value="{{$permission->name}}"

                                                {{-- {{in_array($permission->id, $rolePermissions) ? 'checked' : ''}} --}}
                                                {{$rolePermissions->contains('permission_id', $permission->id) ? 'checked' : ''}}
                                            >
                                        </label>
                                        {{$permission->name}}
                                    </div>
                                @endforeach
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

