@extends("admin.layout.master")
@section("main")
<div class="p-3">
    @if(session('message'))
    <div class="alert alert-danger" role="alert">
        {{session('message')}}
    </div>
    @elseif(session("messageSuccess"))
    <div class="alert alert-success" role="alert">
        {{session('messageSuccess')}}
    </div>
    @endif
</div>
<table class="table">
   <thead>
     <tr>
       <th scope="col">#</th>
       <th scope="col">Content Post</th>
       <th scope="col" class="text-center">Action</th>
     </tr>
   </thead>
   <tbody>
       @foreach ($posts as $post)
        <tr>
            <th scope="row">{{ $post->id }}</th>
            <td>
                <div>
                   {{ $post->content }}
                </div>
                <div class="my-3">
                    @if(!empty($post->images))
                        @php  $images = json_decode($post->images, true); @endphp
                        @if (is_array($images))
                            <div class="flex-wrap d-flex overflow-hidden p-3 w-100">
                                @foreach ($images as $image)
                                    <div class="w-25 p-3">
                                        <img class="w-100" src="{{ asset('/storage/images-post/'.$image) }}"/>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>
            </td>
            <td class="text-center">
                <a href="{{ route("admin.post.edit", ["user" => $user->id, "post" => $post->id]) }}" class="btn btn-warning"><i class="fa-solid fa-pen mr-1"></i>Edit</a>
                <form action="{{ route("admin.post.delete", ["user" => $user->id, "post"=>$post->id]) }}" method="post">
                    @csrf
                    @method("delete")
                    <button type="submit" onClick="return confirm('Are you sure want delete ?')" class="btn btn-danger"><i class="fa-solid fa-trash mr-1"></i>Delete</button>
                </form>
            </td>
        </tr>
       @endforeach
   </tbody>
 </table>
 <div class="mt-3 text-center">
    {{ $posts->links() }}
 </div>
@endsection
