<form class="formAjax" name="{{$id}}" action="{{ route('posts.comments.store', $post->id) }}" method="POST">
    @csrf
    @method('POST')
    <div class="form-group">
        <label for="">Content of reply</label>
        <input type="hidden" value="{{$post->id}}" name="post_id">
        <input type="hidden" value="{{$comment->id}}" name="previous_id">
        <input type="hidden" value="2" name="level">
        <textarea name="content" class="form-control" rows="3" require="required" placeholder="Input content(*)"></textarea>
        @error('content')
            <small>
                <div class="text-danger my-3">{{ $message }}</div>
            </small>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">send reply</button>
</form>
<!-- begin rep -->
<div id="rep" class="container">
<?php
    $replies = $comment->replies;
?>
<h3>replies of comment({{count($replies)}})</h3>
<div>
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
                    <div class="row">
                        <?php
                            $rep_id = 'rep' . $reply->id;
                        ?>
                        <div id="{{$rep_id}}" class="col-9">{{$reply->content}}</div>
                        @if ($reply->user()->get()[0]->id == $user->id)
                            <div class="col-3">
                                <div class="row">
                                    <form class="formAjax" name="{{$rep_id}}" action="{{route('posts.comments.edit', [$post->id, $reply->id])}}" method="GET" class="col-2">
                                        @csrf
                                        @method('GET')
                                        <button type="submit" class="btn btn-primary">Edit</button>
                                    </form>
                                </div>
                                <div class="row">
                                    <form class="formAjax" name="{{$id}}" action="{{route('posts.comments.destroy',[$post->id, $reply->id])}}" method="POST" class="col-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-primary">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                    <!-- begin reaction -->
                    <?php
                        $reactions= $reply->reactions();
                        $id = 'comment' . $reply->id;
                        $reaction_table_id = $reply->id;
                        $reaction_table_type = 'App\Models\Comment';
                    ?>
                    <div id="{{$id}}">
                        @include('app.reaction')
                    </div>
                    <!-- end reaction -->
                </div>
            </div>
        </div>
    @endforeach
</div>
<!-- end rep -->
