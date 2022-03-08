@extends('app-layout.layout')
@section('title', 'Social Network')
<!-- begin post -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<body id="main">
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
        </div>
<!-- end post -->
    @php
    $reactions= $post->reactions();
    $id = 'post' . $post->id;
    $cmt = $post->id . 'post';
    $reaction_table_id = $post->id;
    $reaction_table_type = 'App\Models\Post';
    @endphp
    <!-- begin reaction -->
        <div id="{{$id}}">
        @include('app.reaction')
        </div>
        <div id="{{$cmt}}">
            @include('app.comment');
        </div>
    </div>

@endforeach

{{ $posts->links()}}
@endsection
</body>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('submit', '.formAjax', function(e) {
            e.preventDefault();
            name = $(this).attr('name');
            $.ajax({
                url: $(this).attr('action'),
                type:$(this).attr('method'),
                data:$(this).serialize(),
                success:function(res) {
                    console.log(res);
                    $('#' + name).html(res);
                },
                error: function (request, error) {
                    $('#main').html(error);
                }
            });
        });
    });
</script>
