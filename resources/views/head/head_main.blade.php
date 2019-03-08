@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[], 
	"lang":"{{ App::getlocale() }}",
	"is_auth":"{{  Auth::Check()  }}",
	"api_key":"{{config('constants.api_key')}}",
	@if(Auth::check())
	"user_id":{{ Auth::id() }},
	"tt_navbar":{{ Auth::User()->tt_navbar }},
	"is_following1":{{ $is_following1 }},
	"is_following2":{{ $is_following2 }},
	"f_watch_later":"{{ $f_watch_later }}",
	"watched_movie_number":{{ $watched_movie_number }},
	@endif
	"constants_image_thumb_nail":"{{config('constants.image.thumb_nail')[$image_quality]}}",
	"movies":{!! json_encode($movies) !!},
	"series":{!! json_encode($series) !!},
	"users":{!! json_encode($users) !!},
	"reviews":{!! json_encode($reviews) !!},
	"people":{!! json_encode($people) !!},
	"listes":{!! json_encode($listes) !!}
};
</script>
@endsection

@section('underscore')
@include('cdn.underscore')
@endsection

@section('external_internal_data_merger')
<script src="/js/functions/external_internal_data_merger.js?v={{config('constants.version')}}"></script>
@endsection

@section('angular_controller_js')
<script src="/js/controllers/MainPageController.js?v={{config('constants.version')}}"></script>
@endsection
@section('controllername' ,'MainPageController')

@section('title')
@{{page_variables.notification_count>0?'('+page_variables.notification_count+') ':''}}
{{ __('title.main') }}
@endsection

@section('meta_description')
Get movie recommendations from all over the world based on your unique taste. topcorn.io learns your taste and gives movie advices accordingly. You can filter movies with original languages, years and genres. See movie rating in this personalized movie recommendation engine. @endsection

@section('adsense')
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-5818851352711866",
    enable_page_level_ads: true
  });
</script>
@endsection
