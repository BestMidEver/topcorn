@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":['ngSanitize'], 
	"lang":"{{ App::getlocale() }}", 
	"movieid":{{$id}}, 
	"secondary_lang":"{{ Session::get('secondary_lang') }}", 
	"api_key":"{{config('constants.api_key')}}",
	"is_auth":"{{  Auth::Check()  }}",
	@if(Auth::check())
	"tt_navbar":{{ Auth::User()->tt_navbar }},
	"tt_movie":{{ Auth::User()->tt_movie }},
	"watched_movie_number":{{ $watched_movie_number }}
	@endif
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
@if($movie_title != '')
{{$movie_title}} {{$movie_en_title != '' ? '('.$movie_en_title.') ' : ''}}{{$movie_year}} - topcorn.io
@else
@{{movie.title}}@{{ movie.release_date ? ' (' + movie.release_date.substring(0, 4) + ')' : ''}}{{ __('title.movie') }}
@endif
@endsection

@section('meta_description')
Watch trailer of movie {{$movie_title}} {{$movie_year}}. Read summary, reviews. See full cast, director, writer, original title, original language, producers, budget, revenue, official website. English {{$movie_en_title}}, Türkçe {{$movie_tr_title}}, Magyar {{$movie_hu_title}} 
@endsection