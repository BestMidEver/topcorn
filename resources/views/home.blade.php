@extends('layout.appnew')

@include('head.head_home')

@section('body')
<div class="container-fluid p-0">
	<div class="jumbotron text-sm-center background-white">
		<div class="row">
			<div class="col-12 col-lg-6">
				<div class="h-100 d-flex flex-column justify-content-center">
					<div>
						<h1 class="display-4">Film çok, zaman yok!</h1>
						<p class="lead">Topcorn.io senin film zevkini anlar, senin seveceğini anladığı filmleri sana sıralar. Hazırsan başlayalım!</p>
						<hr class="my-4">
						<p class="my-4 text-muted">Topcorn.io ile her türden, her dilden filmler arasından EN doğru seçimi yapmak, filmfiltre ile senin elinde</p>
						<p class="text-center"><a class="btn btn-warning btn-lg" href="/login"><i class="fa fa-facebook text-left mr-4" aria-hidden="true"></i>{{ __('general.understand_my_taste') }}</a></p>
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
						<h1 class="display-4">Pek Akıllı.</h1>
						<p class="lead">Peşpeşe oylama özelliği, yeni tanıştığınız biriyle sinema zevkiniz üzerine sohbet etmek gibidir. Hangi filmleri izlemiş olabileceğini tahmin ederek profilini geliştirmene yardımcı olur.</p>
						<hr class="my-4">
						<p class="my-4 text-muted">İşin ilginci, tamamen ücretsiz! Filmseversen, bizi de seversin. Hoş geldin!</p>
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
						<h1 class="display-4">Zevkinize göre!</h1>
						<p class="lead">Topcorn.io, seçici filmseverler için oluşturulmuş bir platformdur. Film zevkinizi modülümüzden oylayın, gerisini bize bırakın!</p>
						<hr class="my-4">
						<p class="my-4 text-muted">Zevkler ve renkler tartışılmaz!</p>
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
						<h1 class="display-4">Tamamen ücretsiz!!</h1>
						<p class="lead">Daha ne duruyorsun?</p>
						<hr class="my-4">
						<p class="text-center"><a class="btn btn-warning btn-lg" href="/login" role="button"><i class="fa fa-facebook text-left mr-4" aria-hidden="true"></i>{{ __('general.understand_my_taste') }}</a></p>
						<p class="text-center mb-0"><a class="btn btn-link text-black" href="/register" role="button">{{ __('general.continue_without_facebook') }}</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection