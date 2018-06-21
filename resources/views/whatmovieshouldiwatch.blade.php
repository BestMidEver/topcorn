@extends(Auth::user() ? 'layout.applite' : 'layout.applitenew')

@include('head.head_whatmovieshouldiwatch')

@section('body')
<h1 class="text-center text-md-left col mt-3 mt-md-4">What Movie Should I Watch</h1>

<div class="p-3">
	<p class="lead">Humankind started to make films at the end of the 19th centuary. Since then the film industry grew rapidly. Nowadays we have access to hundreds of thousands of movies. Because we are mortals and we don’t have infinite time, we can’t possibly watch all of them. That makes you ask the question “What movie should I watch?”
	</p>
	<p class="lead">If you came to here to get some movie recommendations from somebody who may or may not share the same movie taste with you, you may scroll down to the bottom of the page for that. Even so I didn’t create this page to announce my “Top 100 Greatest Movies of All Time”. 
	</p>
	<p class="lead"></p>
	<p class="lead"></p>
	<p class="lead"></p>
	<p class="lead"></p>
	<p class="lead"></p>
	<p class="lead"></p>
	<p class="lead"></p>
	<p class="lead"></p>
	<p class="lead"></p>
</div>
@endsection