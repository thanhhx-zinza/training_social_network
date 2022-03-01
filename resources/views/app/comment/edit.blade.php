@extends('app-layout.layout')

@section('title', 'Social Network')

@section('main')
<form action="{{route('posts.comments.update',[$post->id, $comment->id])}}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-floating">
        <div class="row my-3 mx-1">
            <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3">{{ $comment->content }}</textarea>
            @error('content')
            <small>
                <div class="text-danger my-3">{{ $message }}</div>
            </small>
            @enderror
        </div>
        <div class="row">
            <div class="col-10"></div>
            <div class="col-2">
                <button type="submit" class="btn btn-primary">save</button>
            </div>
        </div>
    </div>
</form>
@endsection
