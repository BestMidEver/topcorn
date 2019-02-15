@component('mail::message')
# Hello!

You are receiving this email because {{$name}} new episode air date is defined. Date: {{$next_episode_air_date}} ({{$day_difference_next}} days later)

@component('mail::button', ['url' => url('/').'/series/'.$series_id, 'color' => 'green'])
Check it
@endcomponent

<small>If you don't want to receive emails from us, please click <a href="{{url('/')}}/account/notifications-emails">here</a> and change your settings.</small>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
