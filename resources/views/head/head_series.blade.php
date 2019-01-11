@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":['ngSanitize'], 
	"lang":"{{ App::getlocale() }}", 
	"seriesid":{{$id}}, 
	"secondary_lang":"{{ Session::get('secondary_lang') }}", 
	"api_key":"{{config('constants.api_key')}}",
	"is_auth":"{{  Auth::Check()  }}"
};
</script>
<script src="/js/code_translations/{{ App::getlocale() }}/countries.js"></script>
<script src="/js/code_translations/{{ App::getlocale() }}/languages.js"></script>
<script src="/js/code_translations/{{ App::getlocale() }}/jobs.js"></script>
@endsection

@section('underscore')
@include('cdn.underscore')
@endsection

@section('angular_sanitize')
@include('cdn.angular_sanitize')
@endsection

@section('angular_controller_js')
<script src="/js/controllers/MoviePageController.js"></script>
@endsection
@section('controllername', 'MoviePageController')

@section('title')
series
@endsection

@section('meta_description')

@endsection

@section('og_tags')
<!--<meta property="og:url" content="{{url('/')}}/movie/{{$id}}"/>
<meta property="og:title" content="{{$movie_title}} ({{$movie_year}})"/>
<meta property="og:description" content="Check every detail of {{$movie_title}} ({{$movie_year}}). Read reviews, watch trailers. Find out movie score based on your taste. And so on..."/>
<meta property="og:type" content="video.movie"/>
<meta property="og:image" content="{{config('constants.image.fb_https')}}{{$poster_path}}"/>
<meta property="fb:app_id" content="{{config('constants.facebook.app_id')}}"/>-->
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