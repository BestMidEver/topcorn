@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[],
	@if(Auth::check())
	"tt_navbar":{{ Auth::User()->tt_navbar }},
	"watched_movie_number":{{ $watched_movie_number }}
	@endif
};
</script>
@endsection

@section('angular_controller_js')
<script src="/js/controllers/ListPageController.js"></script>
@endsection
@section('controllername','ListPageController')

@section('title')
{{ __('title.list') }}
@endsection