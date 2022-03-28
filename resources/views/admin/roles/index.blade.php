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
<div class="text-right my-3">
    <a href="{{ route("roles.create") }}" type="button" class="btn btn-success">Create new</a>
</div>
<table class="table">
   <thead>
     <tr>
       <th scope="col">#</th>
       <th scope="col">Name</th>
       <th scope="col" class="text-center">Action</th>
     </tr>
   </thead>
   <tbody>
       @foreach ($roles as $role)
        <tr>
            <th scope="row">{{ $role->id }}</th>
            <td>
                <div>
                   {{ $role->name }}
                </div>
            </td>
            <td class="text-center">
                <a href="{{ route("roles.edit", ["role" => $role->id]) }}" class="btn btn-warning"><i class="fa-solid fa-pen mr-1"></i>Edit</a>
                <form action="{{ route("roles.destroy", ["role" => $role->id]) }}" method="post">
                    @csrf
                    @method("delete")
                    <button type="submit" onClick="return confirm('Are you sure want delete ?')" class="btn btn-danger"><i class="fa-solid fa-trash mr-1"></i>Delete</button>
                </form>
            </td>
        </tr>
       @endforeach
   </tbody>
 </table>
@endsection
