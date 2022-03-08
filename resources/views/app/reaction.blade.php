@php
$reaction = $reactions->likeUser($user->id)->get();
@endphp
@if (!count($reaction))
<div class="col-3">
<form name="{{$id}}" class="formAjax" action="{{route('reactions.store')}}" method="POST">
        @csrf
        @method('POST')
        <input type="hidden" value="{{$id}}" name="name">
        <input type="hidden" name="type" value="like">
        <input type="hidden" name="reaction_table_type" value="{{$reaction_table_type}}">
        <input type="hidden" name="reaction_table_id" value="{{$reaction_table_id}}">
        <button type="submit" class="btn btn-primary">Like</button>
    </form>
    <h5 id="reaction">({{ count($reactions->get()) }})</h5>
</div>
@else
<div class="col-3">
    <form class="formAjax" name="{{$id}}" action="{{route('reactions.destroy', $reaction[0]->id)}}" method="POST">
        @csrf
        @method('DELETE')
        <input type="hidden" value="{{$id}}" name="name">
        <input type="hidden" name="reaction_table_type" value="{{$reaction_table_type}}">
        <input type="hidden" name="reaction_table_id" value="{{$reaction_table_id}}">
        <button class="btn btn-primary">Unlike</button>
    </form>
    <h5 id="reaction1">({{ count($reactions->get()) }})</h5>
</div>
@endif
    <!-- end reaction -->

