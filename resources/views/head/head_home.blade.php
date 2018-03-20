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

@section('meta_description')
There's no time to waste on bad movies! topcorn.io understands your(or your movie group's) unique movie taste and recommends movies based on it. With topcorn.io it's now easy to make the right choice from any kind of movies. Your future best movies are waiting for you to be found. And it is completely free. What are you waiting for?@endsection