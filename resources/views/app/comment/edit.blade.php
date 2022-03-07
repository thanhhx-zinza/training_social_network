@php
    $cmt = $post->id . 'post'
@endphp
<form class="formAjax" name="{{$cmt}}" action="{{route('posts.comments.update', [$post->id, $comment->id])}}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="content" value="{{$comment->content}}">
        <button class="btn btn-outline-secondary" type="submit">ok</button>
    </div>

    </div>
</form>