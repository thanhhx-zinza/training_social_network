@extends('app-layout.layout')

@section('title', 'Social Network')
<!-- bgin post -->
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
                <a class="btn btn-primary btn-sm" href="{{ route('post.edit', ['post' => $post->id]) }}" role="button">Edit</a>
                <a class="btn btn-primary btn-sm" href="{{ route('post.destroy', ['post' => $post->id]) }}" role="button">Delete</a>
            </div>
        </div>
        <div class="row my-3 mx-1">
            <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3" disabled>{{ $post->content }}</textarea>
        </div>
    
<!-- end post -->

<!-- begin post comment -->
<?php
    $user_id = Auth::User()->id;
?>
<div class="container">
    <h3>comment this post</h3>
    @if ($edit)
        <form action="{{route('comment.update')}}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="">Content of comment</label>
                <input type="hidden" value="{{$commentEdit->id}}" name="id">
                <input type="hidden" value="{{$post->id}}" name="post_id">
                <input type="hidden" value="{{$user_id}}" name="user_id">
                <input type="hidden" value="1" name="level">
                <input type="hidden" value="-1" name="previous_id">
                <textarea name="content" class="form-control" rows="3" require="required" placeholder="Input content(*)">{{$commentEdit->content}}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">send comment</button>
    </form>
    @else
        <form action="{{route('comment.store')}}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="">Content of comment</label>
                <input type="hidden" value="{{$post->id}}" name="post_id">
                <input type="hidden" value="{{$user_id}}" name="user_id">
                <input type="hidden" value="1" name="level">
                <input type="hidden" value="-1" name="previous_id">
                <textarea name="content" class="form-control" rows="3" require="required" placeholder="Input content(*)"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">send comment</button>
        </form>
    @endif
<!-- end post comment -->
<?php
    $comments = $post->comments->where('level', 1);
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
                        <h4 class="media-heading">{{$comment->user->profile->first_name}}aa</h4>
                        <div class="row">{{$comment->content}}</div>
                        <div class="row">
                            @if ($comment->user->id == $user_id)
                                <div class="col-2">
                                    <form action="{{route('comment.edit')}}" method="POST" class="col-2">
                                        @csrf
                                        @method('POST')
                                        <input name="id" type="hidden" value="{{$comment->id}}">
                                        <button type="submit" class="btn btn-primary">Edit</button>
                                    </form>
                                </div>
                            <div class="col-3">
                                    <form action="{{route('comment.destroy')}}" method="POST" class="col-2">
                                        @csrf
                                        @method('POST')
                                        <input name="id" type="hidden" value="{{$comment->id}}">
                                        <button type="submit" class="btn btn-primary">Delete</button>
                                    </form>
                            </div>
                            @endif
                        </div>
                        @if ($editRep)
                        <form action="{{route('comment.update')}}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="">Content of reply</label>
                                <input type="hidden" value="{{$commentEdit->id}}" name="id">
                                <input type="hidden" value="{{$post->id}}" name="post_id">
                                <input type="hidden" value="{{$user_id}}" name="user_id">
                                <input type="hidden" value="{{$comment->id}}" name="previous_id">
                                <input type="hidden" value="2" name="level">
                                <textarea name="content" class="form-control" rows="3" require="required" placeholder="Input content(*)">{{$commentEdit->content}}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">send reply</button>
                        </form>
                        @else
                        <form action="{{route('comment.store')}}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="">Content of reply</label>
                                <input type="hidden" value="{{$post->id}}" name="post_id">
                                <input type="hidden" value="{{$user_id}}" name="user_id">
                                <input type="hidden" value="{{$comment->id}}" name="previous_id">
                                <input type="hidden" value="2" name="level">
                                <textarea name="content" class="form-control" rows="3" require="required" placeholder="Input content(*)"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">send reply</button>
                        </form>
                        @endif
                        <div id="rep" class="container">
                            <!-- begin rep -->
                        <?php
                            $replies = $comment->replies;
                        ?>
                        <h3>replies of comment({{count($replies)}})</h3>
                            <div class="comment">
                                @foreach ($replies as $reply)
                                    <?php echo $reply-> id ?>
                                    <div class="media row">
                                        <div class="col-3">
                                        <a class="pull-left" href="#">
                                        <img class="img-fluid" src="https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png" alt="image">
                                            </a>
                                        </div>
                                        <div class="col-9">
                                            <div class="media-body">
                                                <h4 class="media-heading">{{$reply->user->profile->first_name}}aa</h4>
                                                <div class="row">{{$reply->content}}</div>
                                                <div class="row">
                                                    @if ($reply->user->id == $user_id)
                                                        <div class="col-2">
                                                            <form action="{{route('comment.editRep')}}" method="POST" class="col-2">
                                                                @csrf
                                                                @method('POST')
                                                                <input name="id" type="hidden" value="{{$reply->id}}">
                                                                <button type="submit" class="btn btn-primary">Edit</button>
                                                            </form>
                                                        </div>
                                                        <div class="col-3">
                                                            <form action="{{route('comment.destroy')}}" method="POST" class="col-2">
                                                                @csrf
                                                                @method('POST')
                                                                <input name="id" type="hidden" value="{{$reply->id}}">
                                                                <button type="submit" class="btn btn-primary">Delete</button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
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




