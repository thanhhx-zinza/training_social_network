<div class="container">
    <h3>comment this post</h3>
    @php
        $cmt = $post->id . 'post';
    @endphp
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
                            @php
                                $cmt_id = 'cmt' . $comment->id;
                            @endphp
                            <div id="{{$cmt_id}}" class="col-9">{{$comment->content}}</div>
                            @if ($comment->user()->get()[0]->id == $user->id)
                                <div class="col-3">
                                    <div class="row">
                                        <form class="formAjax" name="{{$cmt_id}}" action="{{route('posts.comments.edit', [$post->id, $comment->id])}}" method="GET" class="col-2">
                                            @csrf
                                            @method('GET')
                                            <button type="submit" class="btn btn-primary">Edit</button>
                                        </form>
                                    </div>
                                    <div class="row">
                                        <form class="formAjax" name="{{$cmt}}" action="{{route('posts.comments.destroy',[$post->id, $comment->id])}}" method="POST" class="col-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-primary">Delete</button>
                                        </form>
                                    </div>
                            </div>
                            @endif
                        </div>
                        <!-- begin reaction -->
                        @php
                        $reactions= $comment->reactions();
                        $id = 'comment' . $comment->id;
                        $reaction_table_id = $comment->id;
                        $reaction_table_type = 'App\Models\Comment';
                        @endphp

                        <div id="{{$id}}">
                            @include('app.reaction')
                        </div>

                        <!-- end reaction -->
                        <!-- begin rep -->
                        <div>
                            @include('app.reply');
                        </div>
                        <!-- end rep -->
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<!-- end comment -->
