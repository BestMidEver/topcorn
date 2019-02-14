@component('mail::message')
# Hello!

You are receiving this email because 1 user recommended {{$title}} to you.

@component('mail::button', ['url' => url('/').'/'.$mode.'/'.$movie_id, 'color' => 'green'])
Check it
@endcomponent

<small>If you don't want to receive emails from us, please click <a href="{{url('/')}}/account"></a> and change your settings.</small>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
