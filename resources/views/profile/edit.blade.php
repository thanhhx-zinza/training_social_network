@extends('app-layout.layout')

@section('main')
<!-- Button trigger modal -->
<script>
  
  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };
</script>

<form action = "{{ route('profile.update') }}" method = "POST">
  @csrf
  @method('POST')

  <div id="top1" class="row">
    <div class="col-1">
      <div class="mt-5">
        Eit Profile
      </div>
    </div>
  </div>
  <div id="top2" class="row">
    <div class="mt-5 col-1">
      About
    </div>
    <div class="mt-5 col-2">
      Preference *
    </div>
  </div>
  <div id="top3" class="row">
    <div class="mt-5 col-3">
      Profile Image
    </div>
    <div class="mt-5 col-3">
      <img src="" class="card-img-top" alt="profile image">
    </div>
    <div class="col-6">
      <div class="row">
        <div class="mt-5">
          Select an image file on your computer
        </div>
      </div>
      <div class="row">
        <div class="mt-5 col-6">
          <button type="button" class="btn btn-primary">Choose image</button>
        </div>  
        <div class="mt-5 col-6">
          <button type="button" class="btn btn-primary">Reset profile picture</button>
        </div>
      </div>
    </div>
  </div>
  <div id="top4" class="row mt-5">
    <div class="row mt-5">
      <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">First name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="first_name" value="{{$profiles->first_name}}">
        </div>
      </div>
    </div>
    <div class="row mt-5">
      <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">Last name</label>
        <div class="col-sm-10">
          <input name="last_name" type="text" class="form-control" value="{{$profiles->last_name}}">
        </div>
      </div>
    </div>
    <div class="row mt-5">
      <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">Phone number</label>
        <div class="col-sm-10">
          <input name="phone_number" type="text" class="form-control" value="{{$profiles->phone_number}}">
        </div>
      </div>
    </div>
    <div class="row mt-5">
      <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">Address</label>
        <div class="col-sm-10">
          <input name="address" type="text" class="form-control" value="{{$profiles->address}}">
        </div>
      </div>
    </div>
    <div class="row mt-5">
      <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">Gender</label>
        <div class="col-sm-10">
          <select class="form-select form-control" aria-label="Default select example">
            <option selected>Open this select menu</option>
            <option value="1">Male</option>
            <option value="2">FeMale</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row mt-5">
      <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">Birthday</label>
        <div class="col-sm-10">
          <input name="birthday" type="date" class="form-control" value="{{$profiles->birthday}}">
        </div>
      </div>
    </div>
  </div>
  <div id="top5" class="row mt-5">
    <div class="col-2">
      <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
    <div class="col-4">
      <button type="button" class="btn btn-primary">Cancel</button>
    </div>
  </div>
</form>
@endsection
