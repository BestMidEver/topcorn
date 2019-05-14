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
@if ($person_data)
{{$person_data->name}}{{$person_data->age>0?' ('.$person_data->age.')':''}} | {{ __('long_texts.person.description') }}
@endif
@endsection

@section('og_tags')
<meta property="og:url" content="{{url('/')}}/person/{{$id_dash_title}}/{{App::getlocale()}}"/>
@if ($person_data)
<meta property="og:title" content="{{$person_data->name}}{{$person_data->age>0?' ('.$person_data->age.')':''}}"/>
<meta property="og:description" content="{{ __('long_texts.person.description') }}"/>
<meta property="og:type" content="website"/>
<meta property="og:image" content="{{config('constants.image.thumb_nail')[2].$person_data->profile_path}}"/>
@endif
<meta property="fb:app_id" content="{{config('constants.facebook.app_id')}}"/>
@endsection

@section('amazon_affiliate')
<div class="mt-4 mb-3">
<script type="text/javascript">
amzn_assoc_placement = "adunit0";
amzn_assoc_tracking_id = "topcornio-20";
amzn_assoc_ad_mode = "search";
amzn_assoc_ad_type = "smart";
amzn_assoc_marketplace = "amazon";
amzn_assoc_region = "US";
amzn_assoc_default_search_phrase = "{{$person_data ? $person_data->name : ''}}";
amzn_assoc_default_category = "All";
amzn_assoc_design = "in_content";
amzn_assoc_linkid = "19df56684bc54ebd75ff6227dcf5fca8";
amzn_assoc_title = "";
</script>
<script src="//z-na.amazon-adsystem.com/widgets/onejs?MarketPlace=US"></script>
</div>
@endsection

@section('amazon_affiliate_2')
<div class="mt-5 mb-5">
<script type="text/javascript">
amzn_assoc_placement = "adunit0";
amzn_assoc_tracking_id = "topcornio-20";
amzn_assoc_ad_mode = "search";
amzn_assoc_ad_type = "smart";
amzn_assoc_marketplace = "amazon";
amzn_assoc_region = "US";
amzn_assoc_default_search_phrase = "{{$person_data->name}}";
amzn_assoc_default_category = "{{$amazon_variables[0]}}";
amzn_assoc_linkid = "47db36acc921bab6a2ed3c6ecda0c48f";
amzn_assoc_design = "in_content";
amzn_assoc_default_browse_node = "{{$amazon_variables[1]}}";
</script>
<script src="//z-na.amazon-adsystem.com/widgets/onejs?MarketPlace=US"></script>
</div>
@endsection