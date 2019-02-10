@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[],
	"api_key":"{{config('constants.api_key')}}",
	"tt_navbar":{{ Auth::User()->tt_navbar }},
	"watched_movie_number":{{ $watched_movie_number }},
	"notifications":{{json_decode($notifications,true)}}
};
</script>
@endsection

@section('underscore')
@include('cdn.underscore')
@endsection

@section('angular_controller_js')
<script src="/js/controllers/AccountPageController.js?v={{config('constants.version')}}"></script>
@endsection
@section('controllername','AccountPageController')

@section('title')
{{ __('title.notifications') }}
@endsection