@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[],
	"lang":"{{ App::getlocale() }}", 
	"api_key":"{{config('constants.api_key')}}",
	"tt_navbar":{{ Auth::User()->tt_navbar }},
	"watched_movie_number":{{ $watched_movie_number }},
	"notifications":{!! print($notifications) !!}
};
</script>
@endsection

@section('underscore')
@include('cdn.underscore')
@endsection

@section('angular_controller_js')
<script src="/js/controllers/NotificationsPageController.js?v={{config('constants.version')}}"></script>
@endsection
@section('controllername','NotificationsPageController')

@section('title')
{{ __('title.notifications') }}
@endsection