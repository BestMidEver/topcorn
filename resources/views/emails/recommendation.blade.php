@component('mail::message')
# Hello!

1 user recommended The Sea Inside.

@component('mail::button', ['url' => '/movie/77', 'color' => 'green'])
The Sea Inside
@endcomponent

User: mekk mesterr

Thanks,<br>
{{ config('app.name') }}
@endcomponent
