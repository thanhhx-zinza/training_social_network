@extends("admin.layout.master")
@section("main")
<div class="text-right my-3">
    <a href="{{ route("admins.create") }}" type="button" class="btn btn-success">Create new</a>
</div>
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
       <th scope="col">Name</th>
       <th scope="col">Email</th>
       <th scope="col" class="text-center">Action</th>
     </tr>
   </thead>
   <tbody>
       @foreach ($admins as $admin)
        <tr>
            <th scope="row">{{ $admin->id }}</th>
            <td>{{ $admin->name }}</td>
            <td>{{ $admin->email }}</td>
            <td class="text-center">
                <a href="#" type="button" class="btn btn-primary"><i class="fa-solid fa-eye mr-1"></i>Seen</a>
                <a href="{{ route("admins.edit", ["admin" => $admin->id]) }}" class="btn btn-warning"><i class="fa-solid fa-pen mr-1"></i>Edit</a>
                <form action="{{ route("admins.destroy", ["admin" => $admin->id]) }}" method="post">
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
