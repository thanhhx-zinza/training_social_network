@extends('app-layout.layout')
@section('main')
<h3 class="my-3">Edit profile</h3>
@if ($errors->any())
    <div class="alert alert-danger" role="alert">
      <ul>
     @foreach ($errors->all() as $error)
       <li> {{$error}} </li>
     @endforeach
      </ul>
    </div>
 @endif

 <img class="shadow rounded-circle mx-auto d-block" src="{{ asset('storage/images/'.$profile->avatar) }}" width="200px" height="200px">
 <form class="mt-3" action="{{ route('profile.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <input type="file" name="image" class="form-control">
        </div>
        <div class="col-md-6">
            <button type="submit" class="btn btn-success">Upload</button>
        </div>
    </div>
  </form>

  <form method = "POST" action="{{route('profile.update')}}">
  <div class="mb-3">
    <label for="formGroupExampleInput" class="form-label">First Name</label>
    <input type="text" class="form-control" name="first_name" value="{{$profile->first_name ?? ""}}">
  </div>
  @csrf

  <div class="mb-3">
    <label for="formGroupExampleInput2" class="form-label">Last Name</label>
    <input type="text" class="form-control" name="last_name" value="{{$profile->last_name ?? ""}}">
  </div>
  <div class="mb-3">
    <label for="formGroupExampleInput" class="form-label">Phone number</label>
    <input type="text" class="form-control" name="phone_number" value="{{$profile->phone_number ?? ""}}">
  </div>
  <div class="mb-3">
    <label for="formGroupExampleInput2" class="form-label">Address</label>
    <input type="text" class="form-control" name="address" value="{{old("address", $profile->address ?? "")}}">
  </div>
  <div class="mb-3">
    <label for="formGroupExampleInput2"  class="form-label">Gender</label>
    <select class="form-select mb-3" name = "gender" aria-label="Default select example">
      @if(!empty($profile->gender))
      <option {{ $profile->gender == 1 ? "selected" : ""}} value="1">Male</option>
      <option {{ $profile->gender == 2 ? "selected" : ""}} value="2">FeMale</option>
      @else
      <option  value="1">Male</option>
      <option  value="2">FeMale</option>
       @endif
    </select>
  </div>
  <div class="mb-3">
    <label for="formGroupExampleInput2" class="form-label">Birthday</label>
    <input type="date" class="form-control" name="birthday" value ="{{$profile->birthday ?? ""}}">
  </div>
  <div class="mb-3">
  <button type="submit" class="btn btn-primary">Save Profile</button>
  </div>
</form>

@endsection
