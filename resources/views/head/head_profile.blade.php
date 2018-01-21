@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[], 
	"lang":"{{ App::getlocale() }}",
	"profile_user_id":"{{ $profile_user_id }}", 
	"constants_domain":"{{config('api.url')}}",
};
</script>
@endsection

@section('underscore')
@include('cdn.underscore')
@endsection

@section('angular_controller_js')
<script src="/js/controllers/ProfilePageController.js"></script>
@endsection
@section('controllername' ,'ProfilePageController')

@section('title')
{{ __('title.profile') }}
@endsection