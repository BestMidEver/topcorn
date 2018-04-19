@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[],
	"lang":"{{ App::getlocale() }}", 
	"user_name":"{{ Auth::User()->name }}",
	"cover_src":"{{ Auth::user()->cover_pic }}", 
	"profile_src":"{{Auth::user()->profile_pic}}", 
	"facebook_profile_src":"{{Auth::user()->facebook_profile_pic}}",
	"facebook_link":"{{Auth::user()->facebook_link}}",
	"twitter_link":"{{Auth::user()->twitter_link}}",
	"instagram_link":"{{Auth::user()->instagram_link}}",
	"youtube_link":"{{Auth::user()->youtube_link}}",
	"another_link_name":"{{Auth::user()->another_link_name}}",
	"another_link_url":"{{Auth::user()->another_link_url}}",
	"constants_image_cover":"{{config('constants.image.cover')[$image_quality]}}",
	"constants_image_thumb_nail":"{{config('constants.image.thumb_nail')[$image_quality]}}",
	"api_key":"{{config('constants.api_key')}}",
	"with_message":"{{session()->has('tutorial_504')}}",
	"tt_navbar":{{ Auth::User()->tt_navbar }},
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