@extends('app-layout.layout')

@section('title', 'Social Network')

@section('main')
    @php
        $content = '';
        $audience = '';
        if (old('audience') != null) {
            $content = old('content');
            $audience = old('audience');
        } elseif (isset($post)) {
            $content = $post->content;
            $audience = $post->audience;
        }
    @endphp
    @if (!isset($post))
        <form class="row rounded-3 shadow m-3" method="post" action="{{ route('posts.store') }} "enctype="multipart/form-data">
    @else
        <form class="row rounded-3 shadow m-3" method="post" action="{{ route('posts.update', ['post' => $post->id]) }} "enctype="multipart/form-data">
        @method('PUT')
    @endif
        @csrf
        <div class="row mt-2">
            <div class="col-1">

            </div>
            <div class="col-3">
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
            <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3">{{ $content }}</textarea>
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
        <div class="row mt-3 mx-1">
            <label for="Image" class="form-label">Images</label>
            <input class="form-control" type="file" multiple name="images[]">
        </div>
        @if(isset($post))
            @php
            $images = json_decode($post->images);
            @endphp
            @if (is_array($images))
                <div class="flex-wrap overflow-hidden h-100 p-3 w-100">
                    @foreach ($images as $image)
                        <div class="w-100 p-3">
                            <img  id="frame" class="w-100" src="{{ asset('/storage/images-post/'.$image) }}"/>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
        <div class="row my-3">
            <div class="col-10"></div>
            <div class="col-2">
                <button type="submit" class="btn btn-primary">
                    {{ isset($post) ? 'Update' : 'Post' }}
                </button>
            </div>
        </div>
    </form>
@endsection
