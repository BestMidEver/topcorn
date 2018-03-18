@extends('layout.appnew')

@include('head.head_home')

@section('body')
<div class="container-fluid p-0">
	<div class="jumbotron text-sm-center background-white">
		<div class="row">
			<div class="col-12 col-lg-6">
				<div class="h-100 d-flex flex-column justify-content-center">
					<div>
						<h1 class="display-4">{{ __('long_texts.home.h1') }}</h1>
						<p class="lead">{{ __('long_texts.home.t11') }}</p>
						<hr class="my-4">
						<p class="my-4 text-muted">{{ __('long_texts.home.t12') }}</p>
						<p class="text-center"><a class="btn btn-warning btn-lg" href="{{url('log_in/facebook')}}/false"><i class="fab fa-facebook-square text-left mr-4" aria-hidden="true"></i>{{ __('general.understand_my_taste') }}</a></p>
						<p class="text-center mb-0"><a class="btn btn-link text-black" href="/register">{{ __('general.continue_without_facebook') }}</a></p>
					</div>
				</div>
			</div>
			<div class="col-12 col-lg-6 my-5 my-lg-0">
				<div class="h-100 d-flex flex-column justify-content-center">
					<div class="flex-row justify-content-center">
						<img class="img-fluid" src="/images/examplecard_mac.png">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="jumbotron text-sm-center background-white">
		<div class="row">
			<div class="col-12 col-lg-6 my-5 my-lg-0">
				<div class="h-100 d-flex flex-column justify-content-center">
					<div class="flex-row justify-content-center">
						<img class="img-fluid" src="/images/examplecard_tablet.png">
					</div>
				</div>
			</div>
			<div class="col-12 col-lg-6">
				<div class="h-100 d-flex flex-column justify-content-center">
					<div>
						<h1 class="display-4">{{ __('long_texts.home.h2') }}</h1>
						<p class="lead">{{ __('long_texts.home.t21') }}</p>
						<hr class="my-4">
						<p class="my-4 text-muted">{{ __('long_texts.home.t22') }}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="jumbotron text-sm-center background-white">
		<div class="row">
			<div class="col-12 col-lg-6">
				<div class="h-100 d-flex flex-column justify-content-center">
					<div>
						<h1 class="display-4">{{ __('long_texts.home.h3') }}</h1>
						<p class="lead">{{ __('long_texts.home.t31') }}</p>
						<hr class="my-4">
						<p class="my-4 text-muted">{{ __('long_texts.home.t32') }}</p>
					</div>
				</div>
			</div>
			<div class="col-12 col-lg-6 my-5 my-lg-0">
				<div class="h-100 d-flex flex-column justify-content-center">
					<div class="flex-row justify-content-center">
						<img class="img-fluid" src="/images/examplecard_portrait.png">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="jumbotron text-sm-center background-white">
		<div class="row">
			<div class="col-12 col-lg-6 my-5 my-lg-0">
				<div class="h-100 d-flex flex-column justify-content-center">
					<div class="flex-row justify-content-center">
						<img class="img-fluid" src="/images/examplecard_bigscreen.png">
					</div>
				</div>
			</div>
			<div class="col-12 col-lg-6">
				<div class="h-100 d-flex flex-column justify-content-center">
					<div>
						<h1 class="display-4">{{ __('long_texts.home.h4') }}</h1>
						<p class="lead">{{ __('long_texts.home.t41') }}</p>
						<hr class="my-4">
						<p class="text-center"><a class="btn btn-warning btn-lg" href="{{url('log_in/facebook')}}/false" role="button"><i class="fab fa-facebook-square text-left mr-4" aria-hidden="true"></i>{{ __('general.understand_my_taste') }}</a></p>
						<p class="text-center mb-0"><a class="btn btn-link text-black" href="/register" role="button">{{ __('general.continue_without_facebook') }}</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection