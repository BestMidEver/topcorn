@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[], 
	"lang":"{{ App::getlocale() }}",
	"personid":{{$id}}, 
	"api_key":"{{config('constants.api_key')}}",
	"constants_domain":"{{config('api.url')}}",
	"level":{{ Auth::User()->level }},
	"watched_movie_number":{{ $watched_movie_number }}
};
</script>
<script src="/js/code_translations/{{ App::getlocale() }}/jobs.js"></script>
@endsection

@section('underscore')
@include('cdn.underscore')
@endsection

@section('external_internal_data_merger')
<script src="/js/functions/external_internal_data_merger.js"></script>
@endsection

@section('age_calculator')
<script src="/js/functions/age_calculator.js"></script>
@endsection

@section('angular_controller_js')
<script src="/js/controllers/PersonPageController.js"></script>
@endsection
@section('controllername', 'PersonPageController')

@section('title')
@{{person.name}}{{ __('title.person') }}
@endsection