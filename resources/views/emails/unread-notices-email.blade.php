@component('mail::message')
<div>All Notification Not Read!!! </div>
@foreach ($data as $item)
    <li>{{ $item["data"] }}</li>
@endforeach
Thanks,<br>
{{ config('app.name') }}
@endcomponent
