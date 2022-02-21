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
        <form class="row rounded-3 shadow m-3" method="post" action="{{ route('post.store') }}" enctype="multipart/form-data">
    @else
        <form class="row rounded-3 shadow m-3" method="post" action="{{ route('post.update', ['post' => $post->id]) }}" enctype="multipart/form-data">
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
        <div class="row my-3">
            <div class="col-10"></div>
            <div class="col-2">
                <button type="submit" class="btn btn-primary">
                    {{ isset($post) ? 'Update' : 'Post' }}
                </button>
            </div>
        </div>
    </form>

<!-- begin code comment -->
<div class="container">
	<div class="row">
		<!-- comments section -->
		<div class="row">
			<!-- comment form -->
			<form action = "{{ route('comment.store') }}" method = "POST">
                @csrf
                @method('POST')
				<h4>Post a comment:</h4>
                <input name="post_id" value=1>
				<textarea name="comment_text" id="content" class="form-control" cols="30" rows="3"></textarea>
				<button class="btn btn-primary btn-sm pull-right" id="submit_comment">Submit comment</button>
			</form>

			<!-- Display total number of comments on this post  -->
			<h2><span id="comments_count">0</span> Comment(s)</h2>
			<hr>
			<!-- comments wrapper -->
			<div id="comments-wrapper">
				<div class="comment clearfix">
						<img src="profile.png" alt="" class="profile_pic">
						<div class="comment-details">
							<span class="comment-name">Melvine</span>
							<span class="comment-date">Apr 24, 2018</span>
							<p>This is the first reply to this post on this website.</p>
							<a class="reply-btn" href="#" >reply</a>
						</div>
						<div>
							<!-- reply -->
							<div class="comment reply clearfix">
								<img src="profile.png" alt="" class="profile_pic">
								<div class="comment-details">
									<span class="comment-name">Awa</span>
									<span class="comment-date">Apr 24, 2018</span>
									<p>Hey, why are you the first to comment on this post?</p>
									<a class="reply-btn" href="#">reply</a>
								</div>
							</div>
						</div>
					</div>
			</div>
			<!-- // comments wrapper -->
		</div>
		<!-- // comments section -->
	</div>
</div>
<!-- end code comment -->
@endsection
