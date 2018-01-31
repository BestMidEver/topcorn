@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":['ngSanitize'], 
	"lang":"{{ App::getlocale() }}", 
	"movieid":{{$id}}, 
	"secondary_lang":"{{ Session::get('secondary_lang') }}", 
	"is_auth":"{{  Auth::Check()  }}",
	"constants_domain":"{{config('api.url')}}",
	"api_key":"{{config('constants.api_key')}}",
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
@{{movie.title + movie.release_date>0 ? ' (' + movie.release_date.substring(0, 4) + ')' : ''}}{{ __('title.movie') }}
@endsection