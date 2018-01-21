@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[],
	"lang":"{{ App::getlocale() }}", 
	"constants_domain":"{{config('api.url')}}",
};
</script>
@endsection

@section('underscore')
@include('cdn.underscore')
@endsection

@section('angular_controller_js')
<script src="/js/controllers/AccountInterfacePageController.js"></script>
@endsection
@section('controllername','AccountInterfacePageController')

@section('title')
{{ __('title.account') }}
@endsection