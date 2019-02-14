@component('mail::message')
# Hello!

Someone recommended {{$title}} to you.

@component('mail::button', ['url' => 'https://topcorn.io/$mode/$movie_id, 'color' => 'green'])
Check it
@endcomponent

<small>If you don't want to receive emails from us, please click <a href="https://topcorn.io"></a> and change your settings.</small>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
