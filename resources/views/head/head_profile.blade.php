@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[], 
	"lang":"{{ App::getlocale() }}",
	"profile_user_id":"{{ $profile_user_id }}", 
	"is_auth":"{{  Auth::Check()  }}",
	@if(Auth::check())
	"tt_navbar":{{ Auth::User()->tt_navbar }},
	"watched_movie_number":{{ $watched_movie_number }},
	"watched_series_number":{{ $watched_series_number }}
	@endif
};
</script>
@endsection

@section('underscore')
@include('cdn.underscore')
@endsection

@section('angular_controller_js')
<script src="/js/controllers/ProfilePageController.js"></script>
@endsection
@section('controllername' ,'ProfilePageController')

@section('title')
{{ $profile_user_name.__('title.profile') }}
@endsection