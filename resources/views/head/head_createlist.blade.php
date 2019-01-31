@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[],
	"constants_api_key":"{{config('constants.api_key')}}",
	"lang":"{{ App::getlocale() }}",
	"tt_navbar":{{ Auth::User()->tt_navbar }},
	"watched_movie_number":{{ $watched_movie_number }},
	"liste":{!! json_encode($liste) !!},
	"movies":{!! json_encode($movies) !!}
};
</script>
@endsection

@section('angular_controller_js')
<script src="/js/controllers/CreatelistPageController.js?v={{config('constants.version')}}"></script>
@endsection
@section('controllername','CreatelistPageController')

@section('title')
{{ $liste != '[]' ? __('title.editlist', ['title' => $liste[0]->title]) : __('title.createlist') }}
@endsection