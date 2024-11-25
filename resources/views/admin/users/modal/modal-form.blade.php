<form id="roleForm" method="POST" >
    @csrf
    <input type="hidden" id="userId" name="userId">




    <button type="submit" class="btn btn-primary" id="saveButton">Save</button>
</form>




<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="input-group mb-3">
        <input type="text"  class="form-control"  name="name"  placeholder="Full name">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>
    </div>
    <div class="input-group mb-3">
        <input type="email"  class="form-control" name="email"  placeholder="Email">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>
    </div>
    <div class="input-group mb-3">
        <input type="password" class="form-control" name="password" placeholder="Password">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>

    </div>

     <div class="row mb-3">
        <label for="role" class="col-md-4 col-form-label text-md-end">Role </label>
{{--         @dd($roles) --}}
     <div class="col-md-6">
       <select name ="role_id" class="form-control" required >
        @foreach ($roles as $id => $role )
            <option value="{{$id}}" class="form-control"> {{$role}}</option>
        @endforeach
       </select>
       @error('role_id')
       <span class="text-danger">{{ $message }}</span>
   @enderror
    </div>
     </div>
    <div class="row">
        <div class="col-8">
            {{--                        <div class="icheck-primary">--}}
            {{--                            <input type="checkbox" id="agreeTerms" name="terms" value="agree">--}}
            {{--                            <label for="agreeTerms">--}}
            {{--                                I agree to the <a href="#">terms</a>--}}
            {{--                            </label>--}}
            {{--                        </div>--}}
        </div>
        <!-- /.col -->
        <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </div>
        <!-- /.col -->
    </div>
</form>
