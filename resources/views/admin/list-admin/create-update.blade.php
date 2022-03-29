@extends("admin.layout.master")
@section("main")
<h2 class="p-3">{{ isset($admin) ? 'Update Sub Admin' : 'Create new Sub Admin' }}</h2>
<div class="container">
    <div class="row d-block">
        @if(session('message'))
            <div class="alert alert-error">{{session('message')}}</div>
        @endif
        @if (!isset($admin))
            <form  method="post" action="{{ route('admins.store') }} ">
        @else
            <form  method="post" action="{{ route('admins.update', ['admin' => $admin->id]) }} ">
            @method('PUT')
        @endif
                <div class="form-group row">
                    <label class="col-sm-2" for="exampleFormControlInput1">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" value="{{ isset($admin) ? $admin->name : "" }}" placeholder="Nguyen Van A">
                        @error('name')
                            <div class="text text-danger error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2" for="exampleFormControlInput1">Email</label>
                    <div class="col-sm-10">
                        <input type="email" value="{{ isset($admin) ? $admin->email : "" }}" class="form-control" name="email" placeholder="name@example.com">
                        @error('email')
                            <div class="text text-danger error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2" for="exampleFormControlInput1">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" placeholder="12345678Sos">
                        @error('password')
                            <div class="text text-danger error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2" for="sel1">Select Role:</label>
                    <select class="form-control col-sm-10" multiple id="sel1" name="roles[]">
                        @foreach ($roles as $role)
                            @if (isset($roleOfAdmin) && $roleOfAdmin->count() > 0)
                                <option {{ $roleOfAdmin->contains("id", $role->id) ? "selected" : "" }} value="{{ $role->id }}">{{ $role->name }}</option>
                            @else
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('roles')
                        <div class="offset-sm-2 text text-danger error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group row">
                    <div class="col-sm-10 ml-md-auto">
                        <button type="submit" class="btn btn-primary"> {{ isset($admin) ? 'Update' : 'Create' }}</button>
                    </div>
                </div>
            </form>
    </div>
</div>
@endsection
