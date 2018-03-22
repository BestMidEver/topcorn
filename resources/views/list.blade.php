@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_list')

@section('body')
<h1 class="h4 text-center text-md-left col mt-3 mt-md-4">2000'lerin en iyi bilim kurgu filmleri</h1>

<div class="text-muted col"><small>5 ay önce eklendi, en son 23 gün önce güncellendi.</small></div>

<div class="col mt-2">
	<a href="#">
		<img src="https://graph.facebook.com/v2.10/10211736611553891/picture?type=normal" on-error-src="{{config('constants.image.thumb_nail_error')}}" class="list-thumbnail" alt="Responsive image">
		<span class="text-dark">Szofijjja</span>
	</a>
</div>

<div class="container-fluid mt-3">

	<!--Trailer-->
	<div class="mt-md-4">
		<div class="position-relative">
			<div id="accordion">
				<div>
					<div id="collapseCover" class="collapse show" data-parent="#accordion">
						<img ng-src="https://image.tmdb.org/t/p/w1280/2gJDuPxrZBns5ab47HQbyU2l6Im.jpg" on-error-src="{{config('constants.image.cover_error')}}" class="img-fluid listtrailercover" alt="Responsive image">
						<div class="custom-over-layer h-100 d-flex flex-column justify-content-between">
							<div class="d-flex flex-row no-gutters">
								<div class="col pt-2 pl-2">
									<span class="text-white h6">10. Elveda Las Vegas (1995)</span>
								</div>
								<div class="col p-2 text-right"></div>
							</div>
							<div class="d-flex flex-row justify-content-center" ng-if="1 > 0">
								<button class="btn btn-link text-white btn-lg" ng-click="isfragman=true;" data-toggle="collapse" data-target="#collapseFragman" aria-expanded="false" aria-controls="collapseFragman"><i class="far fa-play-circle mr-2"></i><small>{{ __('general.trailer') }}</small></button>
							</div>
							<div class="d-flex flex-row justify-content-end p-2 text-right"></div>
						</div>
					</div>
				</div>
				<div>
					<div id="collapseFragman" class="collapse" data-parent="#accordion" ng-if="1 > 0">
						<div class="d-flex flex-row background-black no-gutters pl-2 pt-2 pb-3">
							<div class="col">
								<div class="h-100 d-flex flex-column justify-content-center pl-2">
									<span class="text-white h6 lead lead-small">10. Elveda Las Vegas (1995)</span>
								</div>
							</div>
							<div class="col pb-2 pr-2 text-right"></div>
						</div>
						<div class="embed-responsive embed-responsive-1by1 trailer">
							<iframe class="embed-responsive-item" ng-src="https://www.youtube.com/embed/UMlYWZgCIgo" allowfullscreen></iframe>
						</div>
						<div class="d-flex flex-row background-black no-gutters">
							<div class="col">
								<div class="h-100 d-flex flex-column justify-content-center pl-2">
									<div ng-if="2 > 1">
										<button class="btn btn-outline-secondary border-0 btn-lg text-muted hover-white" ng-disabled="false" ng-click="previous_trailer();"><i class="fa fa-step-backward"></i></button>
										<button class="btn btn-outline-secondary border-0 btn-lg text-muted hover-white" ng-disabled="false" ng-click="next_trailer();"><i class="fa fa-step-forward"></i></button>
									</div>
								</div>
							</div>
							<div class="col">
								<div class="h-100 d-flex flex-column justify-content-center text-center">
									<div>
										<button class="btn btn-outline-secondary border-0 btn-lg fa40 text-muted hover-white" ng-click="isfragman = false" data-toggle="collapse" data-target="#collapseCover" aria-expanded="true" aria-controls="collapseCover"><i class="fa fa-angle-up"></i></button>
									</div>
								</div>
							</div>
							<div class="col pb-2 pr-2 text-right"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Trailer-->

	<div class="lead lead-small mt-2">Film karakter çatışması yaşayan bir kadının bir arkadaş grubuna dahil olup yatla gezintiye çıkmasıyla başlar.Ancak bu gezinin sonunun bu şekilde sonuçlanacağından hiçbirisinin haberi yoktur. Psikolojik gerilimin farklı bir tarzı değişik bir film seyretmek isteyenlerin mutlaka izlemesi gereken bir film olduğunu düşünüyorum.İyi seyirler...</div>
</div>

<div class="container-fluid mt-5">

	<!--Trailer-->
	<div class="mt-md-4">
		<div class="position-relative">
			<div id="accordion">
				<div>
					<div id="collapseCover" class="collapse show" data-parent="#accordion">
						<img ng-src="https://image.tmdb.org/t/p/w1280/oBUznaSdjkY3HtQUzAxgdIZqh4w.jpg" on-error-src="{{config('constants.image.cover_error')}}" class="img-fluid listtrailercover" alt="Responsive image">
						<div class="custom-over-layer h-100 d-flex flex-column justify-content-between">
							<div class="d-flex flex-row no-gutters">
								<div class="col pt-2 pl-2">
									<span class="text-white h6">9. Memento (2000)</span>
								</div>
								<div class="col p-2 text-right"></div>
							</div>
							<div class="d-flex flex-row justify-content-center" ng-if="1 > 0">
								<button class="btn btn-link text-white btn-lg" ng-click="isfragman=true;" data-toggle="collapse" data-target="#collapseFragman" aria-expanded="false" aria-controls="collapseFragman"><i class="far fa-play-circle mr-2"></i><small>{{ __('general.trailer') }}</small></button>
							</div>
							<div class="d-flex flex-row justify-content-end p-2 text-right"></div>
						</div>
					</div>
				</div>
				<div>
					<div id="collapseFragman" class="collapse" data-parent="#accordion" ng-if="1 > 0">
						<div class="d-flex flex-row background-black no-gutters pl-2 pt-2 pb-3">
							<div class="col">
								<div class="h-100 d-flex flex-column justify-content-center pl-2">
									<span class="text-white h6 lead lead-small">9. Elveda Las Vegas (2000)</span>
								</div>
							</div>
							<div class="col pb-2 pr-2 text-right"></div>
						</div>
						<div class="embed-responsive embed-responsive-1by1 trailer">
							<iframe class="embed-responsive-item" ng-src="https://www.youtube.com/embed/UMlYWZgCIgo" allowfullscreen></iframe>
						</div>
						<div class="d-flex flex-row background-black no-gutters">
							<div class="col">
								<div class="h-100 d-flex flex-column justify-content-center pl-2">
									<div ng-if="2 > 1">
										<button class="btn btn-outline-secondary border-0 btn-lg text-muted hover-white" ng-disabled="false" ng-click="previous_trailer();"><i class="fa fa-step-backward"></i></button>
										<button class="btn btn-outline-secondary border-0 btn-lg text-muted hover-white" ng-disabled="false" ng-click="next_trailer();"><i class="fa fa-step-forward"></i></button>
									</div>
								</div>
							</div>
							<div class="col">
								<div class="h-100 d-flex flex-column justify-content-center text-center">
									<div>
										<button class="btn btn-outline-secondary border-0 btn-lg fa40 text-muted hover-white" ng-click="isfragman = false" data-toggle="collapse" data-target="#collapseCover" aria-expanded="true" aria-controls="collapseCover"><i class="fa fa-angle-up"></i></button>
									</div>
								</div>
							</div>
							<div class="col pb-2 pr-2 text-right"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Trailer-->

	<div class="lead lead-small mt-2">Kısaca Deja Vu olarak bilinen olayın rahatsız edici gizemini herkes bir şekilde deneyimlemiştir. Birisiyle yeni tanıştığınızda sanki onu yıllardır tanıyormuş gibi bir hisse kapılırsınız. Veya herhangi bir yere ilk defa gittiğiniz halde sanki orada daha önce bulunmuş gibi hissedersiniz. Kısacası Deja Vu adı verilen duyguyu bilmeyen yoktur denilebilir. Peki, ya bu tuhaf ve tüyler ürpertici duygu aslında geçmişten gönderilen bir uyarıysa… Veya bilinmeyen geleceğe dair ipuçlarını barındırıyorsa...</div>
</div>
@endsection