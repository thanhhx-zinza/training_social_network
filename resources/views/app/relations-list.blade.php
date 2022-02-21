@extends('app-layout.layout')

@section('title', 'Social Network')

@section('main')
    <div class="row row-cols-3 g-3 my-3">
        @foreach ($userList as $item)
            <div class="col">
                <div class="card">
                    <img src="..." class="card-img-top" alt="Avatar">
                    <div class="card-body">
                        <h6 class="card-title">{{ $item->name }}</h6>
                        @if ($action == 'add-friend')
                            <form method="post" action="{{ route('relations.add_friend', ['relation' => $item->id]) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                    Add Friend
                                </button>
                            </form>
                            <a href="#" class="btn btn-secondary btn-sm w-100 mt-2">Remove</a>
                        @elseif ($action == 'requests')
                            <form
                                method="post"
                                enctype="multipart/form-data"
                                action="{{ route('relations.response_request', ['relation' => $item->id]) }}"
                            >
                                @method('PATCH')
                                @csrf
                                <input type="submit" class="btn btn-primary btn-sm w-100" name="type" value="Accept">
                                <input type="submit" class="btn btn-secondary btn-sm w-100 mt-2" name="type" value="Decline">
                            </form>
                            <!-- <a href="#" class="btn btn-secondary btn-sm w-100 mt-2">Decline</a> -->
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        {{ $userList->links() }}
    </div>
@endsection
