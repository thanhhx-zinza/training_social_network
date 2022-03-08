@extends('app-layout.layout')

@section('title', 'Social Network')

@section('main')
    <div class="row">
        @foreach ($friends as $item)
            <div class="border col-6 d-flex justify-content-around my-3 p-3">
                <div class="w-50">
                    <img src="https://www.akamai.com/site/im-demo/perceptual-standard.jpg?imbypass=true" class="img-fluid rounded-3" alt="">
                </div>
                <div class="w-50 px-3">
                   <span class="d-block">{{ $item->name ?? "" }}</span>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        {{-- {{ $friends->links() }} --}}
    </div>
@endsection
