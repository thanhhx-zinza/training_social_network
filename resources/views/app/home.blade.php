@extends('app-layout.layout')

@section('title', 'Social Network')

@section('main')
    <form
        class="row rounded-3 shadow m-3"
        method="post"
        action="{{ route('post.store') }}"
        enctype="multipart/form-data"
    >
        @csrf
        <div class="row mt-2">
            <div class="col-1">
                <div>

                </div>
            </div>
            <div class="col-2">
                <p class="m-0 fw-normal">{{ $user->name }}</p>
                <select class="form-select form-select-sm" name="audience" aria-label="Default select example">
                    <option value="public" selected>Public</option>
                    <option value="private">Private</option>
                    <option value="only-me">Only me</option>
                    <option value="friends">Friends</option>
                </select>
            </div>
        </div>
        <div class="row mt-3 mx-1">
            <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <div class="row my-3">
            <div class="col-11"></div>
            <div class="col-1">
                <button type="submit" class="btn btn-primary">Post</button>
            </div>
        </div>
    </form>
@endsection
