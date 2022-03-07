@component('mail::message')
# Introduction

Verify your email now!!!

@component('mail::button', ['url' => $url])
Click here to verify your email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
