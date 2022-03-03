@extends('app-layout.layout')
@section('main')

<div class="row">
    <div class="col-12">
        <a class="d-block mb-3 text-decoration-none text-end text-info" href="{{ route("profile.edit") }}">Edit Profile</a>
    </div>
    <div class="col-12">
        <div class="mx-auto mb-5" style="width: 200px">
            <img src="https://i0.wp.com/9tailedkitsune.com/wp-content/uploads/2020/10/jujutsukaisen.jpg?resize=800%2C445&ssl=1" class="rounded mx-auto d-block w-100" alt="...">
        </div>
    </div>
    <div class="col-12">
        <div class="d-flex fs-5 justify-content-center my-3 text-center">
            <label class="col-3">Last Name : </label> 
            <div class="col-7">
                {{ $profile->last_name ?? "Cập nhật ngay"}}
            </div>
        </div>
        <div class="d-flex fs-5 justify-content-center my-3 text-center">
            <label class="col-3">First Name : </label> 
            <div class="col-7">
                {{ $profile->first_name ?? "Cập nhật ngay"}}
            </div>
        </div>
        <div class="d-flex fs-5 justify-content-center my-3 text-center">
            <label class="col-3">Address: </label> 
            <div class="col-7">
                {{ $profile->address ?? "Cập nhật ngay"}}
            </div>
        </div>
        <div class="d-flex fs-5 justify-content-center my-3 text-center">
            <label class="col-3">Gender: </label> 
            @if(!empty($profile->gender))
            <div class="col-7">
                {{ $profile->gender == 1 ? "Male" : "Female"}}
            </div>
            @else
            <div class="col-7">
                Cập nhật ngay
            </div>
            @endif
        </div>
        <div class="d-flex fs-5 justify-content-center my-3 text-center">
            <label class="col-3">Birtday: </label> 
            <div class="col-7">
                {{ $profile->birthday ?? "Cập nhật ngay"}}
            </div>
        </div>
        <div class="d-flex fs-5 justify-content-center my-3 text-center">
            <label class="col-3">Phone Number: </label> 
            <div class="col-7">
                {{ $profile->phone_number ?? "Cập nhật ngay"}}
            </div>
        </div>
    </div>
</div>
@endsection
