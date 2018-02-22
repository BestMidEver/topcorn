@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":['ngSanitize'], 
	"lang":"{{ App::getlocale() }}", 
	"movieid":{{$id}}, 
	"secondary_lang":"{{ Session::get('secondary_lang') }}", 
	"is_auth":"{{  Auth::Check()  }}",
	"api_key":"{{config('constants.api_key')}}",
	@if(Auth::check())
	"tt_navbar":{{ Auth::User()->tt_navbar }},
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
@{{movie.title}}@{{ movie.release_date ? ' (' + movie.release_date.substring(0, 4) + ')' : ''}}{{ __('title.movie') }}
@endsection