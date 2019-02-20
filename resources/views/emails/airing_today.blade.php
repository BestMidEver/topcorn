@component('mail::message')
# Hello!

You are receiving this email because {{$name}} is in your watch later list and the new episode is airing today.

@component('mail::button', ['url' => url('/').'/series/'.$series_id, 'color' => 'green'])
Check details
@endcomponent

<small>Feel free to reply this mail for any reason. We would appriciate your feedback. (Questions, bugs, critics, advices, grammer correction etc.)</small>

<small>If you don't want to receive emails from us, please click <a href="{{url('/')}}/account/notifications-emails">here</a> and change your settings.</small>

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent
