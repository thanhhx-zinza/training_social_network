@extends('app-layout.layout')
@section('main')
<div class="col-6">
    <div class="row">
        <img src="{{asset('images/avatar.webp')}}" class="img-thumbnail" alt="profile image">
    </div>
    <div class="row mt-5">
        <div class="col-8">
            <h3>{{ $profiles->last_name . ' ' . $profiles->first_name }}</h3>
        </div>
        <div class="col-4">
            <button type="button" class="btn btn-primary">Edit profile</button>
        </div>
    </div>
    <div class="row border">
        <div class="row mt-5">{{$profiles->phone_number}}aaa</div>
        <div class="row mt-5">{{$profiles->address}}</div>
        <div class="row mt-5">{{$profiles->gender}}</div>
        <div class="row mt-5">{{$profiles->birthday}}</div>
    </div>
</div>
@endsection
