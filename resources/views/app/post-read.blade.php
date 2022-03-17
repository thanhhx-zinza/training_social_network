@extends('app-layout.layout')
@section('title', 'Social Network')
<!-- begin post -->
<div id="main">
    @section('main')

        @foreach ($posts as $post)
            <div class="row rounded-3 shadow m-5">
                <div class="row mt-2">
                    <div class="col-1"></div>
                    <div class="col-3">
                        <p class="m-0 fw-normal">{{ $user->name }}</p>
                        <select class="form-select form-select-sm" name="audience" aria-label="Default select example" disabled>
                            <option value="{{ $post->audience }}">
                                {{ $post->audience }}
                            </option>
                        </select>
                    </div>
                    <div class="col-5"></div>
                    <div class="col-3 text-end">
                        <a class="btn btn-primary btn-sm" href="{{ route('posts.edit', ['post' => $post->id]) }}" role="button">Edit</a>
                        <div class="col-2">
                            <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST" class="col-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-primary">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row my-3 mx-1">
                    <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3" disabled>{{ $post->content }}</textarea>
                @php  $images = json_decode($post->images, true); @endphp
                @if (is_array($images))
                    <div class="flex-wrap overflow-hidden h-100 p-3 w-100">
                        @foreach ($images as $image)
                            <div class="w-100 p-3">
                                <img class="w-100" src="{{ asset('/storage/images-post/'.$image) }}"/>
                            </div>
                        @endforeach
                    </div>
                @endif
                </div>
                <?php
                    $reactions= $post->reactions();
                    $id = 'post' . $post->id;
                    $cmt = $post->id . 'post';
                    $reaction_table_id = $post->id;
                    $reaction_table_type = 'App\Models\Post';
                    $comments = $post->comments()->ofLevel($levelParent)->get();
                ?>
                <!-- begin reaction -->
                <div id="{{$id}}" class="m-3">
                    @include('app.reaction')
                </div>
                <h3>comment this post</h3>
                <form class="formAjax" name="{{$cmt}}" action="{{route('posts.comments.store', $post->id)}}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="">Content of comment</label>
                        <input type="hidden" value="1" name="level">
                        <input type="hidden" value="-1" name="previous_id">
                        <textarea name="content" class="form-control" rows="3" require="required" placeholder="Input content(*)"></textarea>
                        @error('content')
                            <small>
                                <div class="text-danger my-3">{{ $message }}</div>
                            </small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary my-3">send comment</button>
                </form>
                <?php
                    $comments = $post->comments()->ofLevel($levelParent)->get();
                ?>
                <h3>Comments of post ({{count($comments)}})</h3>
                <div id="{{$cmt}}">
                    @include('app.comment');
                </div>
            </div>
        @endforeach
        {{ $posts->links()}}
    @endsection
</div>
