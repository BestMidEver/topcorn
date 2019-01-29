@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":['ngSanitize'], 
	"lang":"{{ App::getlocale() }}", 
	"seriesid":{{$id}}, 
	"secondary_lang":"{{ Session::get('secondary_lang') }}", 
	"api_key":"{{config('constants.api_key')}}",
	"is_auth":"{{  Auth::Check()  }}",
	"user_movie_record":{
		"rated_id":{{$rated_id}},
		"rate_code":{{$rate_code}},
		"later_id":{{$later_id}},
		"ban_id":{{$ban_id}},
		"point":{{$point}},
		"p2":{{$p2}},
		"count":{{$count}},
		"percent":{{$percent}}
	}
};
</script>
<script src="/js/code_translations/{{ App::getlocale() }}/countries.js"></script>
<script src="/js/code_translations/{{ App::getlocale() }}/languages.js"></script>
<script src="/js/code_translations/{{ App::getlocale() }}/jobs.js"></script>
@endsection

@section('underscore')
@include('cdn.underscore')
@endsection

@section('external_internal_data_merger')
<script src="/js/functions/external_internal_data_merger.js"></script>
@endsection

@section('angular_sanitize')
@include('cdn.angular_sanitize')
@endsection

@section('angular_controller_js')
<script src="/js/controllers/SeriesPageController.js"></script>
@endsection
@section('controllername', 'MoviePageController')

@section('title')
@if($series_name != '')
{{$series_name}} ({{$series_year}}) - topcorn.io
@else
@{{movie.name}}@{{ movie.first_air_date ? ' (' + movie.first_air_date.substring(0, 4) + ')' : ''}}{{ __('title.movie') }}
@endif
@endsection

@section('meta_description')

@endsection

@section('og_tags')

@endsection

@section('adsense')

@endsection