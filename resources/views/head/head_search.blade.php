@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[], 
	"lang":"{{ App::getlocale() }}",
	"user_id":{{ Auth::id() }}, 
	"constants_image_thumb_nail":"{{config('constants.image.thumb_nail')[$image_quality]}}",
	"constants_api_key":"{{config('constants.api_key')}}",
	"tt_navbar":{{ Auth::User()->tt_navbar }},
	"watched_movie_number":{{ $watched_movie_number }}
};
</script>
@endsection

@section('underscore')
@include('cdn.underscore')
@endsection

@section('external_internal_data_merger')
<script src="/js/functions/external_internal_data_merger.js"></script>
@endsection

@section('angular_controller_js')
<script src="/js/controllers/SearchPageController.js"></script>
@endsection
@section('controllername','SearchPageController')

@section('title')
{{ __('title.search') }}
@endsection