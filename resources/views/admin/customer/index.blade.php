@extends("admin.layout.master")
@section("main")
<div class="text-right my-3">
    <a href="{{ route("customers.create") }}" type="button" class="btn btn-success">Create new</a>
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
       @foreach ($users as $user)
        <tr>
            <th scope="row">{{ $user->id }}</th>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td class="text-center">
                <a href="{{ route("customer-posts.show", ["customer_post" => $user->id]) }}" type="button" class="btn btn-primary"><i class="fa-solid fa-eye mr-1"></i>Seen</a>
                <a href="{{ route("customers.edit", ["customer" => $user->id]) }}" class="btn btn-warning"><i class="fa-solid fa-pen mr-1"></i>Edit</a>
                <form action="{{ route("customers.destroy", ["customer" => $user->id]) }}" method="post">
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
    {{ $users->links() }}
 </div>
@endsection
