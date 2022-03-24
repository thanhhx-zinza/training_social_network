@extends("admin.layout.master")
@section("main")
   <div class="container">
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
    @if(!empty($user) && !empty($post))
       <form enctype="multipart/form-data" method="post" action="{{ route("users.posts.update", ["user" => $user->id, "post" => $post->id]) }}">
        @csrf
        @method("put")
        <div class="form-group">
            <p class="m-0 fw-normal">{{ $user->name }}</p>
            <select class="form-select form-select-sm" name="audience" aria-label="Default select example">
                @foreach ($audiences as $key => $value)
                    <option value="{{ $key }}" {{ ($audience == $key) ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Content</label>
          <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3">{{ $post->content }}</textarea>
        </div>
        <div class="form-group">
            <div class="input-field">
                <label class="active">Photos</label>
                <div class="input-images-1" style="padding-top: .5rem;"></div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    @else
    <h1>Data Not Found</h1>
    @endif
   </div>
@endsection
@push('scripts')
<script>
    $('.input-images-1').imageUploader();
</script>
@if(isset($post) && !empty(json_decode($post->images)))
    <script>
        const images =  {!! $post->images !!}
        const arr = [];
        let url = window.location.href.slice(0, window.location.href.indexOf(window.location.pathname));
        for (const property in images) {
            arr.push({id: property, src: url+'/storage/images-post/'+images[property]});
        }
        $('.input-images-1').imageUploader({
            preloaded: [
                ...arr
            ]
        });
    </script>
@endif
@endpush
