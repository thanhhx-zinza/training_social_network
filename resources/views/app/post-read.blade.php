@extends('app-layout.layout')

@section('title', 'Social Network')
<!-- begin post -->
@section('main')
    @foreach ($posts as $post)
    <div class="row rounded-3 shadow m-5">
        <div class="row mt-2">
            <div class="col-1"></div>
            <div class="col-3">
                <p class="m-0 fw-normal">{{ $userName }}</p>
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
        </div>
<!-- end post -->

    <!-- begin reaction -->
    <div class="row">
        @php
        $reactions= $post->reactions();
        @endphp
        <div class="col-3">
            <form action="{{route('reactions.store')}}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="type" value="like_post">
                <input type="hidden" name="reaction_table_type" value="App\Models\Post">
                <input type="hidden" name="reaction_table_id" value="{{$post->id}}">
                <button type="submit" class="btn btn-primary">Like</button>
            </form>
            <h5>({{ count($reactions->get()) }})</h5>
        </div>
        <div class="col-3">
            <form action="{{route('reactions.destroy', -1)}}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="type" value="like_post">
                <input type="hidden" name="reaction_table_id" value="{{$post->id}}">
                <button class="btn btn-primary">Unlike</button>
            </form>
        </div>
    </div>
    <!-- end reaction -->

<!-- begin post comment -->
<div class="container">
    <h3>comment this post</h3>
    <form action="{{route('posts.comments.store', $post->id)}}" method="POST">
        @csrf
        @method('POST')
        <div class="form-group">
            <label for="">Content of comment</label>
            <input type="hidden" value="1" name="level">
            <input type="hidden" value="-1" name="previous_id">
            <textarea name="content" class="form-control" rows="3" require="required" placeholder="Input content(*)"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">send comment</button>
    </form>
<!-- end post comment -->

<?php
    $comments = $post->comments()->ofLevel(1)->get();
?>

<!-- begin comments -->
    <h3>Comments of post ({{count($comments)}})</h3>
    <div class="comment">
        @foreach ($comments as $comment)
            <div class="media row">
                <div class="col-3">
                <a class="pull-left" href="#">
                <img class="img-fluid" src="https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png" alt="image">
                    </a>
                </div>
                <div class="col-9">
                    <div class="media-body">
                        <h4 class="media-heading">{{$comment->user->profile->first_name}}</h4>
                        <div class="row">
                            <div class="col-9">{{$comment->content}}</div>
                            <div class="col-3">
                            <div class="row">
                                <form action="{{route('posts.comments.edit', [$post->id, $comment->id])}}" method="GET" class="col-2">
                                    @csrf
                                    @method('GET')
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </form>
                            </div>
                            <div class="row">
                                <form action="{{route('posts.comments.destroy',[$post->id, $comment->id])}}" method="POST" class="col-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-primary">Delete</button>
                                </form>
                            </div>
                        </div>
                        </div>
                        <!-- begin reaction -->
                        <div class="row">
                            @php
                            $reactions= $comment->reactions();
                            @endphp
                            <div class="col-3">
                                <form action="{{route('reactions.store')}}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="type" value="like_comment">
                                    <input type="hidden" name="reaction_table_type" value="App\Models\Comment">
                                    <input type="hidden" name="reaction_table_id" value="{{$comment->id}}">
                                    <button type="submit" class="btn btn-primary">Like</button>
                                </form>
                                <h5>({{ count($reactions->get()) }})</h5>
                            </div>
                            <div class="col-3">
                                <form action="{{route('reactions.destroy', -1)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="type" value="like_comment">
                                    <input type="hidden" name="reaction_table_id" value="{{$comment->id}}">
                                    <button class="btn btn-primary">Unlike</button>
                                </form>
                            </div>
                        </div>
                        <!-- end reaction -->
                        <form action="{{ route('posts.comments.store', $post->id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="">Content of reply</label>
                                <input type="hidden" value="{{$post->id}}" name="post_id">
                                <input type="hidden" value="{{$comment->id}}" name="previous_id">
                                <input type="hidden" value="2" name="level">
                                <textarea name="content" class="form-control" rows="3" require="required" placeholder="Input content(*)"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">send reply</button>
                        </form>

                        <!-- begin rep -->
                        <div id="rep" class="container">
                        <?php
                            $replies = $comment->replies;
                        ?>
                        <h3>replies of comment({{count($replies)}})</h3>
                            <div class="comment">
                                @foreach ($replies as $reply)
                                    <div class="media row">
                                        <div class="col-3">
                                        <a class="pull-left" href="#">
                                        <img class="img-fluid" src="https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png" alt="image">
                                            </a>
                                        </div>
                                        <div class="col-9">
                                            <div class="media-body">
                                                <h4 class="media-heading">{{$reply->user->profile->first_name}}</h4>
                                                <div class="row">{{$reply->content}}</div>
                                                <div class="row">
                                                    <div class="col-2">
                                                        <form action="{{route('posts.comments.edit',[$post->id, $reply->id])}}" method="GET" class="col-2">
                                                            @method('GET')
                                                            <button type="submit" class="btn btn-primary">Edit</button>
                                                        </form>
                                                    </div>
                                                    <div class="col-3">
                                                        <form action="{{route('posts.comments.destroy', [$post->id, $reply->id])}}" method="POST" class="col-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-primary">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                 <!-- begin reaction -->
                                                <div class="row">
                                                    @php
                                                    $reaction_replies = $reply->reactions();
                                                   
                                                    @endphp
                                                    <div class="col-3">
                                                        <form action="{{route('reactions.store')}}" method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="type" value="like_comment">
                                                            <input type="hidden" name="reaction_table_type" value="App\Models\Comment">
                                                            <input type="hidden" name="reaction_table_id" value="{{$reply->id}}">
                                                            <button type="submit" class="btn btn-primary">Like</button>
                                                        </form>
                                                        <h5>({{ count($reaction_replies->get()) }})</h5>
                                                    </div>
                                                    <div class="col-3">
                                                        <form action="{{route('reactions.destroy', -1)}}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="type" value="like_comment">
                                                            <input type="hidden" name="reaction_table_id" value="{{$reply->id}}">
                                                            <button class="btn btn-primary">Unlike</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- end reaction -->
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        <!-- end rep -->
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<!-- end comment -->

            </div>

@endforeach

{{ $posts->links()}}
@endsection
