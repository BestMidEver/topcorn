@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":['ngSanitize'], 
	"lang":"{{ App::getlocale() }}", 
	"movieid":{{$id}}, 
	"secondary_lang":"{{ Session::get('secondary_lang') }}", 
	"api_key":"{{config('constants.api_key')}}",
	"is_auth":"{{  Auth::Check()  }}",
	"watch_togethers":{!! json_encode($watch_togethers) !!},
	@if(Auth::check())
	"tt_navbar":{{ Auth::User()->tt_navbar }},
	"tt_movie":{{ Auth::User()->tt_movie }},
	"watched_movie_number":{{ $watched_movie_number }},
	@endif
};
</script>
<script src="/js/code_translations/{{ App::getlocale() }}/countries.js?v={{config('constants.version')}}"></script>
<script src="/js/code_translations/{{ App::getlocale() }}/languages.js?v={{config('constants.version')}}"></script>
<script src="/js/code_translations/{{ App::getlocale() }}/jobs.js?v={{config('constants.version')}}"></script>
@endsection

@section('underscore')
@include('cdn.underscore')
@endsection

@section('angular_sanitize')
@include('cdn.angular_sanitize')
@endsection

@section('external_internal_data_merger')
<script src="/js/functions/external_internal_data_merger.js?v={{config('constants.version')}}"></script>
@endsection

@section('angular_controller_js')
<script src="/js/controllers/MoviePageController.js?v={{config('constants.version')}}"></script>
@endsection
@section('controllername', 'MoviePageController')

@section('title')
@{{page_variables.notification_count>0?'('+page_variables.notification_count+') ':''}}
@if($movie_title != '')
{{$movie_title}} {{$movie_year>0?'('.$movie_year.')':''}} - topcorn.io
@else
@{{movie.title}}@{{ movie.release_date ? ' (' + movie.release_date.substring(0, 4) + ')' : ''}}{{ __('title.movie') }}
@endif
@endsection

@section('meta_description')
Watch trailer of movie {{$movie_title}} {{$movie_year}}. Read summary, reviews and every detail. See full cast, director, writer, original title, original language, producers, budget, revenue, official website. English {{$movie_en_title}}, Türkçe {{$movie_tr_title}}, Magyar {{$movie_hu_title}}@endsection

@section('og_tags')
<meta property="og:url" content="{{url('/')}}/movie/{{$id}}/{{App::getlocale()}}"/>
<meta property="og:title" content="{{$movie_title}} ({{$movie_year}})"/>
<meta property="og:description" content="Check every detail of {{$movie_title}} ({{$movie_year}}). Read reviews, watch trailers. Find out movie score based on your taste. And so on..."/>
<meta property="og:type" content="video.movie"/>
<meta property="og:image" content="{{config('constants.image.fb_https')}}{{$poster_path}}"/>
<meta property="fb:app_id" content="{{config('constants.facebook.app_id')}}"/>
@endsection

@section('adsense')
<!--<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-5818851352711866",
    enable_page_level_ads: true
  });
</script>-->
@endsection