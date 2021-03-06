@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[], 
	"lang":"{{ App::getlocale() }}",
	"is_auth":"{{  Auth::Check()  }}",
	@if(Auth::check())
	"tt_navbar":{{ Auth::User()->tt_navbar }},
	"watched_movie_number":{{ $watched_movie_number }}
	@endif
};
</script>
@endsection

@section('underscore')
@include('cdn.underscore')
@endsection

@section('angular_controller_js')
<script src="/js/controllers/PrivacypolicyPageController.js?v={{config('constants.version')}}"></script>
@endsection
@section('controllername','PrivacypolicyPageController')

@section('title')
@{{page_variables.notification_count>0?'('+page_variables.notification_count+') ':''}}
{{ __('title.privacypolicy') }}
@endsection