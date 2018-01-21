@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[], 
	"lang":"{{ App::getlocale() }}", 
};
</script>
@endsection

@section('angular_controller_js')
<script src="/js/controllers/HomePageController.js"></script>
@endsection
@section('controllername','HomePageController')

@section('title')
{{ __('title.home') }}
@endsection