@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_list')

@section('body')
<h1 class="h5 text-center text-md-left col mt-3 mt-md-4">2000'lerin en iyi bilim kurgu filmleri</h1>

<div class="py-3 col">
	<h6 class="lead">Film önerisi mi lazım? Hangi filmi izlesem diye kara kara düşünüyor musun?
20 farklı kategori, 140'ın üzerinde farklı liste, binlerce farklı film... Sinemasever okurlarımıza yaz havaları gelmişken ne hediye versek diye düşündük, izle izle bitiremeyeceğiniz devasa bir film arşivini layık gördük. İzlenebilecek filmler arıyorsanız doğru yerdesiniz. Bu listenin tamamını bitirmek aylar alıyor! </h6>
</div>

<div class="card-group no-gutters">
	<div class="px-2 mt-4 col-12 col-xl-6">
		<div class="card h-100">
			<a href="#" data-toggle="tooltip" data-placement="top" title="Jackie Brown">
				<div class="d-flex flex-row justify-content-between">
					<div class="d-flex flex-column">
						<span class="text-dark h5 p-1">10.</span>
					</div>
					<div class="d-flex flex-column">
						<span class="text-dark h6 p-1">Jackie Brown (1997)</span>
					</div>
					<div class="d-flex flex-column"></div>
				</div>
			</a>
			<div class="row no-gutters pt-2">
				<div class="col-4">
					<img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/4XVPYOdMAizdNMSwS0SK3fPJcvR.jpg" on-error-src="" class="card-img-top" alt="Responsive image">
				</div>

				<div class="col-8 lead lead-small">
					<div class="pl-3 pr-1 pb-1">Amerika'nın en uyduruk havayollarından birinde hava hostesi olan Jackie Brown'ın emekliliği giderek yaklaşmaktadır. Hostesimiz ayın sonunu getirebilmek için silah kaçakçısı Ordell için çalışmaktadır. Polis durumdan haberdardır. Ordell de polisin haberdar olduğundan ve dolayısıyla Jackie'nin hayatının bıçak sırtında olduğundan.Olaylar ortaya çıktığuında Jackie ve Ordell cephelerine yeni yardımcılar katılır ve herkes yarım milyon doların peşine düşer.Yönetmen Tarantino, hayranı olduğu, 70'li yılların kült zenci dizisi "Foxy Brown"ın kadın oyuncusu Palm Grier'e Jackie Brown rolün sonunu getirebilmek için silah kaçakçısı Ordell için çalışmaktadır. Polis durumdan haberdardır. Ordell de polisin haberdar olduğundan ve dolayısıyla Jackie'nin hayatının bıçak sırtında olduğundan.Olaylar ortaya çıktığuında Jackie ve Ordell cephelerine yeni yardımcılar katılır ve herkes yarım milyon doların peşine düşer.Yönetmen Tarantino, hayranı olduğu, 70'li yılların kült zenci dizisi "Foxy Brown"ın kadın oyuncusu Palm Grier'e Jackie Brown rolünü vererek tam onikiden vuruyor.</div>
				</div>
			</div>
		</div>
	</div>
	<div class="px-2 mt-4 col-12 col-xl-6">
		<div class="card h-100">
			<span class="text-dark h6 p-1">9. Başka Bir Dünya (1997)</span>
			<div class="row no-gutters pt-2">
				<div class="col-4">
					<img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/gJy7LMq4b5qO5fsSUSoBgm24BHf.jpg" on-error-src="" class="card-img-top" alt="Responsive image">
				</div>

				<div class="col-8 lead lead-small">
					<div class="pl-3 pr-1 pb-1">Kanada'nın taşrasında geçiyor olay. Yıllarca okul otobüsü ile, yitik evlerden topladığı çocukları okula götürüp getiren ve sahip olamadığı çocukların tüm sevgisini onlara vermiş kadın şöför Dolores, (Gabrielle Rose) o gün bir kaza yapıyor. Tüm çocuklar, buzun kapladığı bir gölün derin sularında boğularak ölüyor. Korkunç kazadan sonra Stephens adında bir Avukat çıkageliyor (Ian Holm) ve üzüntülü anne - babaları hukuk nezdinde temsil edip kazaya bir sorumlu aramak ve onlardan yüklü bir tazminat koparmak gayesiyle kolları sıvıyor.</div>
				</div>
			</div>
		</div>
	</div>
	<div class="px-2 mt-4 col-12 col-xl-6">
		<div class="card h-100">
			<span class="text-dark h6 p-1">8. Elveda Las Vegas (1995)</span>
			<div class="row no-gutters pt-2">
				<div class="col-4">
					<img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/37qHRJxnSh5YkuaN9FgfNnMl3Tj.jpg" on-error-src="" class="card-img-top" alt="Responsive image">
				</div>

				<div class="col-8 lead lead-small">
					<div class="pl-3 pr-1 pb-1">Alkol sorunları yüzünden herşeyini kaybetmiş olan Hollywood senaristi Ben Sanderson ( Cage) ölümüne içmek için Las Vegas'a gelir. Burada tesadüfen tanışacağı hayat kadını Sera ( Shue ) ile aşka dönüşen ilişkisi ise artık hayata farklı bir açıdan bakmasına sebep olacaktır</div>
				</div>
			</div>
		</div>
	</div>
	<div class="px-2 mt-4 col-12 col-xl-6">
		<div class="card h-100">
			<span class="text-dark h6 p-1">10. Jackie Brown (1997)</span>
			<div class="row no-gutters pt-2">
				<div class="col-4">
					<img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/4XVPYOdMAizdNMSwS0SK3fPJcvR.jpg" on-error-src="" class="card-img-top" alt="Responsive image">
				</div>

				<div class="col-8 lead lead-small">
					<div class="pl-3 pr-1 pb-1">Amerika'nın en uyduruk havayollarından birinde hava hostesi olan Jackie Brown'ın emekliliği giderek yaklaşmaktadır. Hostesimiz ayın sonunu getirebilmek için silah kaçakçısı Ordell için çalışmaktadır. Polis durumdan haberdardır. Ordell de polisin haberdar olduğundan ve dolayısıyla Jackie'nin hayatının bıçak sırtında olduğundan.Olaylar ortaya çıktığuında Jackie ve Ordell cephelerine yeni yardımcılar katılır ve herkes yarım milyon doların peşine düşer.Yönetmen Tarantino, hayranı olduğu, 70'li yılların kült zenci dizisi "Foxy Brown"ın kadın oyuncusu Palm Grier'e Jackie Brown rolünü vererek tam onikiden vuruyor.</div>
				</div>
			</div>
		</div>
	</div>
	<div class="px-2 mt-4 col-12 col-xl-6">
		<div class="card h-100">
			<span class="text-dark h6 p-1">9. Başka Bir Dünya (1997)</span>
			<div class="row no-gutters pt-2">
				<div class="col-4">
					<img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/gJy7LMq4b5qO5fsSUSoBgm24BHf.jpg" on-error-src="" class="card-img-top" alt="Responsive image">
				</div>

				<div class="col-8 lead lead-small">
					<div class="pl-3 pr-1 pb-1">Kanada'nın taşrasında geçiyor olay. Yıllarca okul otobüsü ile, yitik evlerden topladığı çocukları okula götürüp getiren ve sahip olamadığı çocukların tüm sevgisini onlara vermiş kadın şöför Dolores, (Gabrielle Rose) o gün bir kaza yapıyor. Tüm çocuklar, buzun kapladığı bir gölün derin sularında boğularak ölüyor. Korkunç kazadan sonra Stephens adında bir Avukat çıkageliyor (Ian Holm) ve üzüntülü anne - babaları hukuk nezdinde temsil edip kazaya bir sorumlu aramak ve onlardan yüklü bir tazminat koparmak gayesiyle kolları sıvıyor.</div>
				</div>
			</div>
		</div>
	</div>
	<div class="px-2 mt-4 col-12 col-xl-6">
		<div class="card h-100">
			<span class="text-dark h6 p-1">8. Elveda Las Vegas (1995)</span>
			<div class="row no-gutters pt-2">
				<div class="col-4">
					<img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/37qHRJxnSh5YkuaN9FgfNnMl3Tj.jpg" on-error-src="" class="card-img-top" alt="Responsive image">
				</div>

				<div class="col-8 lead lead-small">
					<div class="pl-3 pr-1 pb-1">Alkol sorunları yüzünden herşeyini kaybetmiş olan Hollywood senaristi Ben Sanderson ( Cage) ölümüne içmek için Las Vegas'a gelir. Burada tesadüfen tanışacağı hayat kadını Sera ( Shue ) ile aşka dönüşen ilişkisi ise artık hayata farklı bir açıdan bakmasına sebep olacaktır</div>
				</div>
			</div>
		</div>
	</div>
	<div class="px-2 mt-4 col-12 col-xl-6">
		<div class="card h-100">
			<span class="text-dark h6 p-1">10. Jackie Brown (1997)</span>
			<div class="row no-gutters pt-2">
				<div class="col-4">
					<img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/4XVPYOdMAizdNMSwS0SK3fPJcvR.jpg" on-error-src="" class="card-img-top" alt="Responsive image">
				</div>

				<div class="col-8 lead lead-small">
					<div class="pl-3 pr-1 pb-1">Amerika'nın en uyduruk havayollarından birinde hava hostesi olan Jackie Brown'ın emekliliği giderek yaklaşmaktadır. Hostesimiz ayın sonunu getirebilmek için silah kaçakçısı Ordell için çalışmaktadır. Polis durumdan haberdardır. Ordell de polisin haberdar olduğundan ve dolayısıyla Jackie'nin hayatının bıçak sırtında olduğundan.Olaylar ortaya çıktığuında Jackie ve Ordell cephelerine yeni yardımcılar katılır ve herkes yarım milyon doların peşine düşer.Yönetmen Tarantino, hayranı olduğu, 70'li yılların kült zenci dizisi "Foxy Brown"ın kadın oyuncusu Palm Grier'e Jackie Brown rolünü vererek tam onikiden vuruyor.</div>
				</div>
			</div>
		</div>
	</div>
	<div class="px-2 mt-4 col-12 col-xl-6">
		<div class="card h-100">
			<span class="text-dark h6 p-1">9. Başka Bir Dünya (1997)</span>
			<div class="row no-gutters pt-2">
				<div class="col-4">
					<img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/gJy7LMq4b5qO5fsSUSoBgm24BHf.jpg" on-error-src="" class="card-img-top" alt="Responsive image">
				</div>

				<div class="col-8 lead lead-small">
					<div class="pl-3 pr-1 pb-1">Kanada'nın taşrasında geçiyor olay. Yıllarca okul otobüsü ile, yitik evlerden topladığı çocukları okula götürüp getiren ve sahip olamadığı çocukların tüm sevgisini onlara vermiş kadın şöför Dolores, (Gabrielle Rose) o gün bir kaza yapıyor. Tüm çocuklar, buzun kapladığı bir gölün derin sularında boğularak ölüyor. Korkunç kazadan sonra Stephens adında bir Avukat çıkageliyor (Ian Holm) ve üzüntülü anne - babaları hukuk nezdinde temsil edip kazaya bir sorumlu aramak ve onlardan yüklü bir tazminat koparmak gayesiyle kolları sıvıyor.</div>
				</div>
			</div>
		</div>
	</div>
	<div class="px-2 mt-4 col-12 col-xl-6">
		<div class="card h-100">
			<span class="text-dark h6 p-1">8. Elveda Las Vegas (1995)</span>
			<div class="row no-gutters pt-2">
				<div class="col-4">
					<img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/37qHRJxnSh5YkuaN9FgfNnMl3Tj.jpg" on-error-src="" class="card-img-top" alt="Responsive image">
				</div>

				<div class="col-8 lead lead-small">
					<div class="pl-3 pr-1 pb-1">Alkol sorunları yüzünden herşeyini kaybetmiş olan Hollywood senaristi Ben Sanderson ( Cage) ölümüne içmek için Las Vegas'a gelir. Burada tesadüfen tanışacağı hayat kadını Sera ( Shue ) ile aşka dönüşen ilişkisi ise artık hayata farklı bir açıdan bakmasına sebep olacaktır</div>
				</div>
			</div>
		</div>
	</div>
	<div class="px-2 mt-4 col-12 col-xl-6">
		<div class="card h-100">
			<span class="text-dark h6 p-1">10. Jackie Brown (1997)</span>
			<div class="row no-gutters pt-2">
				<div class="col-4">
					<img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/4XVPYOdMAizdNMSwS0SK3fPJcvR.jpg" on-error-src="" class="card-img-top" alt="Responsive image">
				</div>

				<div class="col-8 lead lead-small">
					<div class="pl-3 pr-1 pb-1">Amerika'nın en uyduruk havayollarından birinde hava hostesi olan Jackie Brown'ın emekliliği giderek yaklaşmaktadır. Hostesimiz ayın sonunu getirebilmek için silah kaçakçısı Ordell için çalışmaktadır. Polis durumdan haberdardır. Ordell de polisin haberdar olduğundan ve dolayısıyla Jackie'nin hayatının bıçak sırtında olduğundan.Olaylar ortaya çıktığuında Jackie ve Ordell cephelerine yeni yardımcılar katılır ve herkes yarım milyon doların peşine düşer.Yönetmen Tarantino, hayranı olduğu, 70'li yılların kült zenci dizisi "Foxy Brown"ın kadın oyuncusu Palm Grier'e Jackie Brown rolünü vererek tam onikiden vuruyor.</div>
				</div>
			</div>
		</div>
	</div>
	<div class="px-2 mt-4 col-12 col-xl-6">
		<div class="card h-100">
			<span class="text-dark h6 p-1">9. Başka Bir Dünya (1997)</span>
			<div class="row no-gutters pt-2">
				<div class="col-4">
					<img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/gJy7LMq4b5qO5fsSUSoBgm24BHf.jpg" on-error-src="" class="card-img-top" alt="Responsive image">
				</div>

				<div class="col-8 lead lead-small">
					<div class="pl-3 pr-1 pb-1">Kanada'nın taşrasında geçiyor olay. Yıllarca okul otobüsü ile, yitik evlerden topladığı çocukları okula götürüp getiren ve sahip olamadığı çocukların tüm sevgisini onlara vermiş kadın şöför Dolores, (Gabrielle Rose) o gün bir kaza yapıyor. Tüm çocuklar, buzun kapladığı bir gölün derin sularında boğularak ölüyor. Korkunç kazadan sonra Stephens adında bir Avukat çıkageliyor (Ian Holm) ve üzüntülü anne - babaları hukuk nezdinde temsil edip kazaya bir sorumlu aramak ve onlardan yüklü bir tazminat koparmak gayesiyle kolları sıvıyor.</div>
				</div>
			</div>
		</div>
	</div>
	<div class="px-2 mt-4 col-12 col-xl-6">
		<div class="card h-100">
			<span class="text-dark h6 p-1">8. Elveda Las Vegas (1995)</span>
			<div class="row no-gutters pt-2">
				<div class="col-4">
					<img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/37qHRJxnSh5YkuaN9FgfNnMl3Tj.jpg" on-error-src="" class="card-img-top" alt="Responsive image">
				</div>

				<div class="col-8 lead lead-small">
					<div class="pl-3 pr-1 pb-1">Alkol sorunları yüzünden herşeyini kaybetmiş olan Hollywood senaristi Ben Sanderson ( Cage) ölümüne içmek için Las Vegas'a gelir. Burada tesadüfen tanışacağı hayat kadını Sera ( Shue ) ile aşka dönüşen ilişkisi ise artık hayata farklı bir açıdan bakmasına sebep olacaktır</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row mt-5 no-gutters">
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
	<div class="col-6 col-md-4 col-xl-3 mt-3 float-right pl-0">
		<div class="float-right">
			<div class="fb-like" data-href="https://topcorn.io/list/1" data-layout="box_count" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>

			<div class="fb-share-button ml-2" data-href="https://topcorn.io/list/1" data-layout="box_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Ftopcorn.io%2Flist%2F1&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Paylaş</a></div>
		</div>
	</div>
</div>

<div class="container-fluid px-0 pt-5">
	<span class="h5 mb-0">{{ __('general.fb_comments') }}</span>
	<div class="fb-comments" data-href="https://topcorn.io/list/1" data-width="100%" data-numposts="6" data-colorscheme="{{Auth::check()?(Auth::User()->theme==1?'dark':'light'):''}}"></div>
</div>
@endsection