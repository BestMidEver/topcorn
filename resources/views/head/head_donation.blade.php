@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":['ngAnimate', 'ngSanitize', 'ui.bootstrap'], 
	"lang":"{{ App::getlocale() }}",
	"constants_domain":"{{config('api.url')}}",
	"level":{{ Auth::User()->level }},
	"watched_movie_number":{{ $watched_movie_number }}
};
</script>
@endsection

@section('underscore')
@include('cdn.underscore')
@endsection

@section('angular_controller_js')
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-animate.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-sanitize.js"></script>
<script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-2.5.0.js"></script>
<script src="/js/controllers/DonationPageController.js"></script>
@endsection
@section('controllername','DonationPageController')

@section('title')
{{ __('title.donation') }}
@endsection