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
<script src="/js/functions/external_internal_data_merger.js?v={{config('constants.version')}}"></script>
@endsection

@section('angular_controller_js')
<script src="/js/controllers/SearchPageController.js?v={{config('constants.version')}}"></script>
@endsection
@section('controllername','SearchPageController')

@section('title')
@{{page_variables.notification_count>0?'('+page_variables.notification_count+') ':''}}
{{ __('title.search') }}
@endsection

@section('amazon_affiliate')
<div class="mt-4 mb-5">
<script type="text/javascript">
amzn_assoc_placement = "adunit0";
amzn_assoc_tracking_id = "topcornio-20";
amzn_assoc_ad_mode = "search";
amzn_assoc_ad_type = "smart";
amzn_assoc_marketplace = "amazon";
amzn_assoc_region = "US";
amzn_assoc_default_search_phrase = "{{$amazon_variables_general[0]}}";
amzn_assoc_default_category = "{{$amazon_variables_general[1]}}";
amzn_assoc_linkid = "47db36acc921bab6a2ed3c6ecda0c48f";
amzn_assoc_design = "in_content";
amzn_assoc_default_browse_node = "{{$amazon_variables_general[2]}}";
</script>
<script src="//z-na.amazon-adsystem.com/widgets/onejs?MarketPlace=US"></script>
</div>
@endsection