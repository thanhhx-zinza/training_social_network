@extends("admin.layout.master")
@section("main")
<h2 class="p-3">Create new permission</h2>
<div class="container">
    <div class="row d-block">
        @if(session('message'))
            <div class="alert alert-error">{{session('message')}}</div>
        @endif
        <form  method="post" action="{{ route('permission.store') }} " >
        <div class="form-group row">
            <label class="col-sm-2" for="sel1">Select parent permission:</label>
            <select class="col-sm-10 form-control" id="sel1" name="module_parent">
                @foreach (config("permission.table_module") as $module)
                    <option value="{{ $module }}"><span class="text-uppercase">{{ "Module ".$module }}</span></option>
                @endforeach
            </select>
          </div>
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2" for="exampleFormControlInput1">Permission</label>
                    <div class="col-sm-10">
                        <div class="row">
                            @foreach (config("permission.childrent_module") as $item)
                                <div class="col-md-3 form-check">
                                    <input class="form-check-input" value={{ $item }} name="module_childrent[]" type="checkbox" id="gridCheck">
                                    <label class="form-check-label" for="gridCheck">{{ $item }}</label>
                                </div>
                            @endforeach
                        </div>
                        @error('permission')
                            <div class="text text-danger error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10 ml-md-auto">
                        <button type="submit" class="btn btn-primary"> Create</button>
                    </div>
                </div>
            </form>
    </div>
</div>
@endsection
