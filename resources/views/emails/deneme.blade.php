@component('mail::message')
# Introduction

mekk mesterr "watch together" with you. You can use share button to recommend movies and series to this user.

@component('mail::button', ['url' => 'https://laravel.com/docs/5.5/mail#generating-markdown-mailables', 'color' => 'green'])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
