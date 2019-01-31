@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[],
	"lang":"{{ App::getlocale() }}", 
	"tt_navbar":{{ Auth::User()->tt_navbar }},
	"watched_movie_number":{{ $watched_movie_number }}
};
</script>
@endsection

@section('underscore')
@include('cdn.underscore')
@endsection

@section('angular_controller_js')
<script src="/js/controllers/AccountPasswordPageController.js?v={{config('constants.version')}}"></script>
@endsection
@section('controllername','AccountPasswordPageController')

@section('title')
{{ __('title.account') }}
@endsection