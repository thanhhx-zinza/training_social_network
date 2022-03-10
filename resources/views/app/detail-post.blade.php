@extends('app-layout.layout')

@section('title', 'Social Network')
<!-- begin post -->
@section('main')
    <div class="row rounded-3 shadow m-5">
        <div class="row mt-2">
            <div class="col-1"></div>
            <div class="col-3">
                <p class="m-0 fw-normal">{{ Auth::user()->name }}</p>
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
        <?php
            $reactions= $post->reactions();
            $id = 'post' . $post->id;
            $cmt = $post->id . 'post';
            $reaction_table_id = $post->id;
            $reaction_table_type = 'App\Models\Post';
        ?>
        <!-- begin reaction -->
        @include('app.reaction')
        <h3>comment this post</h3>
        <?php
            $cmt = $post->id . 'post';
        ?>
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
            $comments = $post->comments()->ofLevel(1)->newestComment()->paginate(2);
            $num = $comments->lastPage();
        ?>
        <div id="num" value="{{$num}}"></div>
        <!-- begin comments -->
        <h3>Comments of post ({{count($comments)}})</h3>
        <div id="ad">
            <div id="{{$cmt}}">@include('app.detail-post-comment')</div>
        </div>
        <div id="page_last"></div>
    </div>
    <script>
        if (!page) {
            var page=1;
        }
        $(window).scroll(function() { //detect page scroll
            if($(window).scrollTop() == $(document).height() - $(window).height()) { //if user scrolled from top to bottom of the page
                page++; //page number increment
                if (page <= parseInt($('#num').attr('value'),10)) {
                    console.log('a');
                    load_more(page); //load content
                }
                if (page == parseInt($('#num').attr('value'),10) + 1) {
                    alert('no data for you');
                    $(window).disable = true;
                    setTimeout(function(){$(window).disabled = false;},5);
                }
            }
        });
        function load_more(page){
            $.ajax({
                url: "?page=" + page,
                type: "get",
                beforeSend: function() {
                    $('.ajax-loading').show();
                }
            })
            .done(function(data)
            {
                $('.ajax-loading').hide(); //hide loading animation once data is received
                $("#ad").append($(data).find('#ad').html()); //append data into #results element
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                alert('No response from server');
            });
        }
    </script>
    <div class="ajax-loading"><img src="{{ asset('storage/images/1646807464.gif') }}" /></div>
@endsection
