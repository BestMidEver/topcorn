@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[], 
	"lang":"{{ App::getlocale() }}",
	"constants_domain":"{{config('api.url')}}",
	@if(Auth::check())
	"tt_navbar":{{ Auth::User()->tt_navbar }},
	"watched_movie_number":{{ $watched_movie_number }},
	"level":{{ Auth::User()->level }}
	@endif
};
</script>
@endsection

@section('underscore')
@include('cdn.underscore')
@endsection

@section('angular_controller_js')
<script src="/js/controllers/PrivacypolicyPageController.js"></script>
@endsection
@section('controllername','PrivacypolicyPageController')

@section('title')
{{ __('title.privacypolicy') }}
@endsection