@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":['rzModule'], 
	"lang":"{{ App::getlocale() }}",
	"user_id":{{ Auth::id() }}, 
	"constants_image_thumb_nail":"{{config('constants.image.thumb_nail')[$image_quality]}}",
	"constants_domain":"{{config('api.url')}}",
	"constants_angular_slider_min_value":"{{config('constants.angular_slider.min_value')}}",
	"constants_angular_slider_max_value":"{{config('constants.angular_slider.max_value')}}",
	"with_user_id":"{!! session('with_user_id') !!}",
	"with_user_name":"{!! session('with_user_name') !!}",
	@if(Auth::check())
	"tt_navbar":{{ Auth::User()->tt_navbar }},
	"watched_movie_number":{{ $watched_movie_number }}
	@endif
};
</script>
<script src="/js/code_translations/{{ App::getlocale() }}/genres.js"></script>
<script src="/js/code_translations/{{ App::getlocale() }}/languages.js"></script>
@endsection

@section('angular_slider')
@include('cdn.angular_slider')
@endsection

@section('underscore')
@include('cdn.underscore')
@endsection

@section('angular_controller_js')
<script src="/js/controllers/RecommendationsPageController.js"></script>
@endsection
@section('controllername' ,'RecommendationsPageController')

@section('title')
{{ __('title.recommendations') }}
@endsection