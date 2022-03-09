@component('mail::message')
# Introduction

All Notification Not Read!!!
@foreach ($data as $item)
    <li>{{ $item["data"] }}</li>
@endforeach

Thanks,<br>
{{ config('app.name') }}
@endcomponent
