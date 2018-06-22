@extends(Auth::user() ? 'layout.applite' : 'layout.applitenew')

@include('head.head_whatmovieshouldiwatch')

@section('body')
<div class="col-12 col-lg-8">
	<h1 class="text-center text-md-left col mt-3 mt-md-4">What Movie Should I Watch</h1>

	<div class="p-3">
		<div class="jumbotron">
			<p class="lead">This website is the answer of this question! I explain it you <strong>right now</strong>.</p>
		</div>
		<p>Humankind started to make films at the end of the 19th centuary. Since then the film industry grew rapidly. Nowadays we have access to hundreds of thousands of movies. Because we are mortals and we don’t have infinite time, we can’t possibly watch all of them. That makes you ask the question <strong>What movie should I watch?</strong>
		</p>
		<div class="jumbotron">
			<p class="lead">There are more movies than we can possibly watch!</p>
			<div class="quote-line">In the past 10 years, film production has doubled, going from 4,584 in 2005, to 9,387 in 2015. <a href="https://www.quora.com/How-many-films-are-produced-each-year" target="_blank"><i class="fas fa-external-link-alt"></i></a>
			<img src="https://qph.ec.quoracdn.net/main-qimg-f914caf8040406fec63fccd09b32f040.webp" class="img-fluid" alt="Responsive image"></div>
		</div>
		<p></p>
	</div>
</div>
@endsection

