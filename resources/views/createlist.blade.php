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
		<a href="#" class="text-no-decoration" data-toggle="tooltip" data-placement="top" title="Jackie Brown">
			<div class="card h-100">
					<span class="text-dark h6 p-1 text-hover-underline">10. Jackie Brown (1997)</span>
				<div class="row no-gutters pt-2">
					<div class="col-4">
						<img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/4XVPYOdMAizdNMSwS0SK3fPJcvR.jpg" on-error-src="" class="card-img-top" alt="Responsive image">
					</div>

					<div class="col-8 lead lead-small">
						<div class="pl-3 pr-1 pb-1 text-dark">Amerika'nın en uyduruk havayollarından birinde hava hostesi olan Jackie Brown'ın emekliliği giderek yaklaşmaktadır. Hostesimiz ayın sonunu getirebilmek için silah kaçakçısı Ordell için çalışmaktadır. Polis durumdan haberdardır. Ordell de polisin haberdar olduğundan ve dolayısıyla Jackie'nin hayatının bıçak sırtında olduğundan.Olaylar ortaya çıktığuında Jackie ve Ordell cephelerine yeni yardımcılar katılır ve herkes yarım milyon doların peşine düşer.Yönetmen Tarantino, hayranı olduğu, 70'li yılların kült zenci dizisi "Foxy Brown"ın kadın oyuncusu Palm Grier'e Jackie Brown rolün sonunu getirebilmek için silah kaçakçısı Ordell için çalışmaktadır. Polis durumdan haberdardır. Ordell de polisin haberdar olduğundan ve dolayısıyla Jackie'nin hayatının bıçak sırtında olduğundan.Olaylar ortaya çıktığuında Jackie ve Ordell cephelerine yeni yardımcılar katılır ve herkes yarım milyon doların peşine düşer.Yönetmen Tarantino, hayranı olduğu, 70'li yılların kült zenci dizisi "Foxy Brown"ın kadın oyuncusu Palm Grier'e Jackie Brown rolünü vererek tam onikiden vuruyor.</div>
					</div>
				</div>
			</div>
		</a>
	</div>
</div>
@endsection