@extends("admin.layout.master")
@section("main")
<h2 class="p-3">{{ isset($roles) ? 'Update Role' : 'Create new Role' }}</h2>
<div class="container">
    <div class="row d-block">
        @if(session('message'))
            <div class="alert alert-error">{{session('message')}}</div>
        @endif
        @if (!isset($roles))
            <form  method="post" action="{{ route('roles.store') }} ">
        @else
            <form  method="post" action="{{ route('roles.update', ['role' => $roles->id]) }} ">
            @method('PUT')
        @endif
                <div class="form-group row">
                    <label class="col-sm-2" for="exampleFormControlInput1">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" value="{{ isset($roles) ? $roles->name : "" }}" placeholder="">
                        @error('name')
                            <div class="text text-danger error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2" for="exampleFormControlInput1">Permission</label>
                </div>
                @foreach ($permissions as $permission)
                <div class="bg-warning form-group p-2 row">
                    <label class="col-sm-2" for="exampleFormControlInput1">Manager <span class="text-capitalize">{{ $permission->name }}</span></label>
                    <div class="col-sm-10">
                        <div class="row">
                            @foreach ($permission->childrent as $item)
                            <div class="col-md-3 form-check">
                                <input class="form-check-input" {{ isset($permissionChecked) && $permissionChecked->contains("id", $item->id) ? "checked" : "" }} value = {{ $item->id }} name="permission[]" type="checkbox" id="gridCheck">
                                <label class="form-check-label" for="gridCheck">
                                  {{ $item->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @error('permission')
                            <div class="text text-danger error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @endforeach
                <div class="form-group row">
                    <div class="col-sm-10 ml-md-auto">
                        <button type="submit" class="btn btn-primary"> {{ isset($roles) ? 'Update' : 'Create' }}</button>
                    </div>
                </div>
            </form>
    </div>
</div>
@endsection
