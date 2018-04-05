@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[],
	"constants_api_key":"{{config('constants.api_key')}}",
	"lang":"{{ App::getlocale() }}",
	"tt_navbar":{{ Auth::User()->tt_navbar }},
	"watched_movie_number":{{ $watched_movie_number }},
	"liste":{!! $liste !!}
};
</script>
@endsection

@section('angular_controller_js')
<script src="/js/controllers/CreatelistPageController.js"></script>
@endsection
@section('controllername','CreatelistPageController')

@section('title')
{{ __('title.createlist') }}
@endsection