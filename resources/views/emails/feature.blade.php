@component('mail::message')
# Hello!

{{$notification}}

@component('mail::button', ['url' => url('/'), 'color' => 'green'])
Check it
@endcomponent

<small>If you don't want to receive emails from us, please click <a href="{{url('/')}}/account/notifications-emails">here</a> and change your settings.</small>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
