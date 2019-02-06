@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":['rzModule'], 
	"lang":"{{ App::getlocale() }}",
	"is_auth":"{{  Auth::Check()  }}",
	"constants_api_key":"{{config('constants.api_key')}}",
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
	"constants_angular_slider_min_vote_count":"{{config('constants.angular_slider.vote_count')}}",
	"constants_angular_slider_vote_count_floor":"{{config('constants.angular_slider.vote_count_floor')}}",
	"constants_angular_slider_vote_count_ceil":"{{config('constants.angular_slider.vote_count_ceil')}}",
	"constants_angular_slider_vote_count_step":"{{config('constants.angular_slider.vote_count_step')}}",
	"constants_angular_slider_min_match_percentage":"{{config('constants.angular_slider.match_percentage')}}",
	"constants_angular_slider_match_percentage_floor":"{{config('constants.angular_slider.match_percentage_floor')}}",
	"constants_angular_slider_match_percentage_ceil":"{{config('constants.angular_slider.match_percentage_ceil')}}",
	"constants_angular_slider_match_percentage_step":"{{config('constants.angular_slider.match_percentage_step')}}"
};
</script>
<script src="/js/code_translations/{{ App::getlocale() }}/genres.js?v={{config('constants.version')}}"></script>
<script src="/js/code_translations/{{ App::getlocale() }}/series_genres.js?v={{config('constants.version')}}"></script>
<script src="/js/code_translations/{{ App::getlocale() }}/languages.js?v={{config('constants.version')}}"></script>
@endsection

@section('angular_slider')
@include('cdn.angular_slider')
@endsection

@section('underscore')
@include('cdn.underscore')
@endsection

@section('angular_controller_js')
<script src="/js/controllers/RecommendationsPageController.js?v={{config('constants.version')}}"></script>
@endsection
@section('controllername' ,'RecommendationsPageController')

@section('title')
{{ __('title.recommendations') }}
@endsection

@section('meta_description')
Get movie recommendations from all over the world based on your unique taste. topcorn.io learns your taste and gives movie advices accordingly. You can filter movies with original languages, years and genres. See movie rating in this personalized movie recommendation engine. @endsection

<!--
@section('adsense')
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-5818851352711866",
    enable_page_level_ads: true
  });
</script>
@endsection
-->