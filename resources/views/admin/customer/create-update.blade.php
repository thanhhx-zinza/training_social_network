@extends("admin.layout.master")
@section("main")
<h2 class="p-3">{{ isset($user) ? 'Update User' : 'Create new user' }}</h2>
<div class="container">
    <div class="row d-block">
        @if (isset($errors) ? $errors->any() : "")
            <div class="row mt-2 mx-1">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if(session('message'))
            <div class="alert alert-error">{{session('message')}}</div>
        @endif
        @if (!isset($user))
            <form  method="post" action="{{ route('users.store') }} ">
        @else
            <form  method="post" action="{{ route('users.update', ['user' => $user->id]) }} ">
            @method('PUT')
        @endif
                <div class="form-group row">
                    <label class="col-sm-2" for="exampleFormControlInput1">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" value="{{ isset($user) ? $user->name : "" }}" placeholder="Nguyen Van A">
                    </div>
                </div>
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2" for="exampleFormControlInput1">Email</label>
                    <div class="col-sm-10">
                        <input type="email" value="{{ isset($user) ? $user->email : "" }}" class="form-control" name="email" placeholder="name@example.com">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2" for="exampleFormControlInput1">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" placeholder="12345678Sos">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10 ml-md-auto">
                        <button type="submit" class="btn btn-primary"> {{ isset($user) ? 'Update' : 'Create' }}</button>
                    </div>
                </div>
            </form>
    </div>
</div>
@endsection
