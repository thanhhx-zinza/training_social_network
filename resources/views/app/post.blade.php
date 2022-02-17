@extends('app-layout.layout')

@section('title', 'Social Network')

@section('main')
    @php
        $audience = (old('audience') != null) ? old('audience') : 'public';
    @endphp
    <form
        class="row rounded-3 shadow m-3"
        method="post"
        action="{{ route('post.store') }}"
        enctype="multipart/form-data"
    >
        @csrf
        <div class="row mt-2">
            <div class="col-1">

            </div>
            <div class="col-2">
                <p class="m-0 fw-normal">{{ $user->name }}</p>
                <select class="form-select form-select-sm" name="audience" aria-label="Default select example">
                    @foreach ($audiences as $key => $value)
                        <option value="{{ $key }}" {{ ($audience == $key) ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mt-3 mx-1">
            <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3">{{ (old('content') != null) ? old('content') : '' }}</textarea>
        </div>
        @if ($errors->any())
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
        <div class="row my-3">
            <div class="col-11"></div>
            <div class="col-1">
                <button type="submit" class="btn btn-primary">Post</button>
            </div>
        </div>
    </form>
@endsection
