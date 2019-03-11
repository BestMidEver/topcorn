@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[], 
	"lang":"{{ App::getlocale() }}",
	"personid":{{$id}}, 
	"api_key":"{{config('constants.api_key')}}",
	"is_auth":"{{  Auth::Check()  }}",
	@if(Auth::check())
	"tt_navbar":{{ Auth::User()->tt_navbar }},
	"watched_movie_number":{{ $watched_movie_number }}
	@endif
};
</script>
<script src="/js/code_translations/{{ App::getlocale() }}/jobs.js?v={{config('constants.version')}}"></script>
@endsection

@section('underscore')
@include('cdn.underscore')
@endsection

@section('external_internal_data_merger')
<script src="/js/functions/external_internal_data_merger.js?v={{config('constants.version')}}"></script>
@endsection

@section('age_calculator')
<script src="/js/functions/age_calculator.js?v={{config('constants.version')}}"></script>
@endsection

@section('angular_controller_js')
<script src="/js/controllers/PersonPageController.js?v={{config('constants.version')}}"></script>
@endsection
@section('controllername', 'PersonPageController')

@section('title')
@{{page_variables.notification_count>0?'('+page_variables.notification_count+') ':''}}
@{{person.name}}{{ __('title.person') }}
@endsection

@section('meta_description')
{{ __('long_texts.home.description') }}
@endsection

@section('og_tags')
<meta property="og:url" content="{{url('/')}}/person/{{$id}}"/>
<meta property="og:title" content="@{{person.name}} @{{age}}"/>
<meta property="og:description" content="@{{person.place_of_birth}} - @{{person.birthday.length>0?person.birthday:''}}"/>
<meta property="og:type" content="website"/>
<meta property="og:image" content="{{config('constants.image.thumb_nail')[$image_quality]}}@{{person.profile_path}}"/>
<meta property="fb:app_id" content="{{config('constants.facebook.app_id')}}"/>
@endsection