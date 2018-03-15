@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":['rzModule'], 
	"lang":"{{ App::getlocale() }}",
	"is_auth":"{{  Auth::Check()  }}",
	@if(Auth::check())
	"user_id":{{ Auth::id() }},
	"with_user_id":"{!! session('with_user_id') !!}",
	"with_user_name":"{!! session('with_user_name') !!}",
	"tt_navbar":{{ Auth::User()->tt_navbar }},
	@endif
	"watched_movie_number":{{ $watched_movie_number }},
	"constants_image_thumb_nail":"{{config('constants.image.thumb_nail')[$image_quality]}}",
	"constants_angular_slider_min_value":"{{config('constants.angular_slider.min_value')}}",
	"constants_angular_slider_max_value":"{{config('constants.angular_slider.max_value')}}",
	"constants_angular_slider_min_vote_count":"{{config('constants.angular_slider.vote_count')}}"
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