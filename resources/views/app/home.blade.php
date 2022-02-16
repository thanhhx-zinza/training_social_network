@extends('app-layout.layout')

@section('title', 'Social Network')

@section('main')
    <form class="row rounded-3 shadow m-3" method="post" action="" enctype="multipart/form-data">
        @csrf
        <div class="row mt-2">
            <div class="col-1">
                <div>

                </div>
            </div>
            <div class="col-2">
                <p class="m-0 fw-normal">Pham Tung</p>
                <select class="form-select form-select-sm" name="audience" aria-label="Default select example">
                    <option selected>Public</option>
                    <option value="1">Private</option>
                    <option value="2">Only me</option>
                    <option value="3">Friends</option>
                </select>
            </div>
        </div>
        <div class="row mt-3 mx-1">
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <div class="row my-3">
            <div class="col-11"></div>
            <div class="col-1">
                <button type="submit" class="btn btn-primary">Post</button>
            </div>
        </div>
    </form>
@endsection
