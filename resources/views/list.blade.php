@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_list')

@section('body')
<h1 class="h3 text-center text-md-left col px-0 mt-3 mt-md-4">2000'lerin en iyi bilim kurgu filmleri</h1>

<div class="container-fluid px-md-2">
	<div class="mt-5 row">
		<div class="col">
			<span class="text-dark h5">10. Jackie Brown (1997)</span>
			<div class="row pt-2">
				<div class="col-6 col-md-3 col-xl-2">
					<img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/4XVPYOdMAizdNMSwS0SK3fPJcvR.jpg" on-error-src="" class="card-img-top" alt="Responsive image">
				</div>

				<div class="col-3 lead lead-small mt-2">Amerika'nın en uyduruk havayollarından birinde hava hostesi olan Jackie Brown'ın emekliliği giderek yaklaşmaktadır. Hostesimiz ayın sonunu getirebilmek için silah kaçakçısı Ordell için çalışmaktadır. Polis durumdan haberdardır. Ordell de polisin haberdar olduğundan ve dolayısıyla Jackie'nin hayatının bıçak sırtında olduğundan.Olaylar ortaya çıktığuında Jackie ve Ordell cephelerine yeni yardımcılar katılır ve herkes yarım milyon doların peşine düşer.Yönetmen Tarantino, hayranı olduğu, 70'li yılların kült zenci dizisi "Foxy Brown"ın kadın oyuncusu Palm Grier'e Jackie Brown rolünü vererek tam onikiden vuruyor.</div>
			</div>
		</div>
		<div class="col">
			<span class="text-dark h5">9. Başka Bir Dünya (1997)</span>
			<div class="row pt-2">
				<div class="col-6 col-md-3 col-xl-2">
					<img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/4XVPYOdMAizdNMSwS0SK3fPJcvR.jpg" on-error-src="" class="card-img-top" alt="Responsive image">
				</div>

				<div class="col-3 lead lead-small mt-2">Kanada'nın taşrasında geçiyor olay. Yıllarca okul otobüsü ile, yitik evlerden topladığı çocukları okula götürüp getiren ve sahip olamadığı çocukların tüm sevgisini onlara vermiş kadın şöför Dolores, (Gabrielle Rose) o gün bir kaza yapıyor. Tüm çocuklar, buzun kapladığı bir gölün derin sularında boğularak ölüyor. Korkunç kazadan sonra Stephens adında bir Avukat çıkageliyor (Ian Holm) ve üzüntülü anne - babaları hukuk nezdinde temsil edip kazaya bir sorumlu aramak ve onlardan yüklü bir tazminat koparmak gayesiyle kolları sıvıyor.</div>
			</div>
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