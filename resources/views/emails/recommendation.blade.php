@component('mail::message')
# Hello!

1 user recommended The Sea Inside.

@component('mail::button', ['url' => 'https://laravel.com/docs/5.5/mail#generating-markdown-mailables', 'color' => 'green'])
The Sea Inside
@endcomponent

User: mekk mesterr

Thanks,<br>
{{ config('app.name') }}
@endcomponent
