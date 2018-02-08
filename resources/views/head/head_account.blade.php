@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[],
	"lang":"{{ App::getlocale() }}", 
	"cover_src":"{{ Auth::user()->cover_pic }}", 
	"profile_src":"{{Auth::user()->profile_pic}}", 
	"facebook_profile_src":"{{Auth::user()->facebook_profile_pic}}",
	"constants_image_cover":"{{config('constants.image.cover')[$image_quality]}}",
	"constants_image_thumb_nail":"{{config('constants.image.thumb_nail')[$image_quality]}}",
	"constants_domain":"{{config('api.url')}}",
	"api_key":"{{config('constants.api_key')}}",
	"with_message":"{{session()->has('tutorial_500')}}",
	"level":{{ Auth::User()->level }},
	"watched_movie_number":{{ $watched_movie_number }}
};
</script>
@endsection

@section('underscore')
@include('cdn.underscore')
@endsection

@section('angular_controller_js')
<script src="/js/controllers/AccountPageController.js"></script>
@endsection
@section('controllername','AccountPageController')

@section('title')
{{ __('title.account') }}
@endsection