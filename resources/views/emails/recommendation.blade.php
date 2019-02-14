@component('mail::message')
# Hello!

1 user recommended The Sea Inside. User: mekk mesterr

@component('mail::button', ['url' => 'https://laravel.com/docs/5.5/mail#generating-markdown-mailables', 'color' => 'green'])
The Sea Inside
@endcomponent






<small>If you don't want to receive emails from us, please click here and change your settings.</small>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
