@foreach ($posts as $post)
<div class="row rounded-3 shadow m-5">
    <div class="row mt-2">
        <div class="col-1"></div>
        <div class="col-3">
            <p class="m-0 fw-normal">{{ $post->profile->getFullName() }}</p>
            <select class="form-select form-select-sm" name="audience" aria-label="Default select example" disabled>
                <option value="{{ $post->audience }}">
                    {{ $post->audience }}
                </option>
            </select>
        </div>
    </div>
    <div class="row my-3 mx-1">
        <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3" disabled>{{ $post->content }}</textarea>
    </div>
    @php
        $reactions = $post->reactions();
        $id = 'post'.$post->id;
        $reaction_table_id = $post->id;
        $reaction_table_type = 'App\Models\Post';
    @endphp
    @include('app.reaction')
</div>
@endforeach
