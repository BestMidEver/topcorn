@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_list')

@section('body')
<h1 class="h3 text-center text-md-left col px-0 mt-3 mt-md-4">2000'lerin en iyi bilim kurgu filmleri</h1>

<div class="container-fluid px-md-2">
	<div class="mt-5">
		<span class="text-dark h5">10. Elveda Las Vegas (1995)</span>
		<div class="row">
			<img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/4XVPYOdMAizdNMSwS0SK3fPJcvR.jpg" on-error-src="" class="card-img-top" alt="Responsive image">

			<div class="col-5 lead lead-small mt-2">Film karakter çatışması yaşayan bir kadının bir arkadaş grubuna dahil olup yatla gezintiye çıkmasıyla başlar.Ancak bu gezinin sonunun bu şekilde sonuçlanacağından hiçbirisinin haberi yoktur. Psikolojik gerilimin farklı bir tarzı değişik bir film seyretmek isteyenlerin mutlaka izlemesi gereken bir film olduğunu düşünüyorum.İyi seyirler...</div>
		</div>
	</div>

	<div class="row">
		<div class="col-6 col-md-8 col-xl-9 mt-3">
			<a href="#" class="text-no-decoration">
				<div class="d-flex flex-row">
					<div class="d-flex flex-column">
						<img src="https://graph.facebook.com/v2.10/10211736611553891/picture?type=normal" on-error-src="{{config('constants.image.thumb_nail_error')}}" class="list-thumbnail" alt="Responsive image">
					</div>
					<div class="d-flex flex-column justify-content-center ml-2">
						<h6 class="text-dark text-hover-underline mb-0">Szofijjja</h6>
						<div class="text-muted"><small class="text-no-decoration">5 ay önce ekledi, en son 23 gün önce güncelledi.</small></div>
					</div>
				</div>
			</a>
		</div>
		<div class="col-6 col-md-4 col-xl-3 mt-3 float-right">
			<div class="float-right">
				<div class="fb-like" data-href="https://topcorn.io/list/1" data-layout="box_count" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>

				<div class="fb-share-button ml-2" data-href="https://topcorn.io/list/1" data-layout="box_count" data-size="large" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Ftopcorn.io%2Flist%2F1&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Paylaş</a></div>
			</div>
		</div>
	</div>
@endsection