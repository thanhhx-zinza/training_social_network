@extends('app-layout.layout')

@section('title', 'Social Network')

@section('main')
    <form class="row mx-2" method="post" action="{{ route('settings.change_settings') }}" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <h1 class="text-center mt-3">Settings</h1>
        <ul class="col list-group p-0">
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">Notifications</div>
                    Get notifications
                </div>
                <div class="form-check form-switch">
                    <input
                        class="form-check-input form-switch form-control-sm"
                        type="checkbox"
                        role="switch"
                        id="switch-notifications"
                        name="isNoti"
                        {{ ($setting->is_noti == 1) ? 'checked' : '' }}
                    >
                </div>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">Add Friend</div>
                    Get add friends
                </div>
                <div class="form-check form-switch">
                    <input
                        class="form-check-input form-switch form-control-sm"
                        type="checkbox"
                        role="switch"
                        id="switch-add-friend"
                        name="isAddFriend"
                        {{ ($setting->is_add_friend == 1) ? 'checked' : '' }}
                    >
                </div>
            </li>
        </ul>
        <div class="col-10 "></div>
        <div class="col-2 my-3 text-end">
            <button class="btn btn-primary" type="submit">Save</button>
        </div>
    </form>
@endsection
