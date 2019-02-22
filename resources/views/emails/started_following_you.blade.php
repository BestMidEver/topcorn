@component('mail::message')
# Hello!

You are receiving this email because {{$user_name}} started following you.

@component('mail::button', ['url' => url('/').'/profile/'.$user_id, 'color' => 'green'])
Check user's profile
@endcomponent

<small>Feel free to reply this mail for any reason. We would appriciate your feedback. (Questions, bugs, critics, advices, grammer correction etc.)</small>

<small>If you don't want to receive emails from us, please click <a href="{{url('/')}}/account/notifications-emails">here</a> and change your settings.</small>

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent
