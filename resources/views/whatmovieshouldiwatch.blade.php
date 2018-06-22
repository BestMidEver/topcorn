@extends(Auth::user() ? 'layout.applite' : 'layout.applitenew')

@include('head.head_whatmovieshouldiwatch')

@section('body')
<div class="col-12 col-lg-8">
	<h1 class="text-center text-md-left col mt-3 mt-md-4">What Movie Should I Watch</h1>

	<div class="p-3">
		<div class="jumbotron">
			<p class="lead">This website is the answer of this question! I explain it you <strong>right now</strong>.</p>
		</div>
		<p>Humankind started to make films at the end of the 19th century. Since then the film industry grew rapidly. Nowadays we have access to hundreds of thousands of movies. Because we are mortals and we don’t have infinite time, we can’t possibly watch all of them. That makes you ask the question <strong>What movie should I watch?</strong>
		</p>
		<div class="jumbotron">
			<p class="lead">There are more movies than we can possibly watch!</p>
			<div class="quote-line">
				<div class="mb-2">In the past 10 years, film production has doubled, going from 4,584 in 2005, to 9,387 in 2015. <a href="https://www.quora.com/How-many-films-are-produced-each-year" target="_blank"><i class="fas fa-external-link-alt"></i></a></p>
				<img src="https://qph.ec.quoracdn.net/main-qimg-f914caf8040406fec63fccd09b32f040.webp" class="img-fluid" alt="Films Per Year Graph"></div>
			</div>
		</div>
		<p>That means:</p>
		<p><strong>No time to waste on bad movies!</strong></p>
		<p>If you came here to get some movie recommendations from somebody who may or may not share the same movie taste with you, you may scroll down to the bottom of the page for that. Even so I didn’t create this page to announce my “Top 100 Greatest Movies of All Time”.</p>
		<p>Look:</p>
		<p>When you search movies on internet, you will possibly end up at lists which are created by individuals. Of course there is a chance that these individuals share similar movie taste with you but in my opinion it is less likely. You may end up at some websites which display top 250 lists and so on but this lists are created by everyone. And if you don’t share similar movie taste with majority… On the other hand, Topcorn.io offers <strong>customized movie recommendation</strong> list in addition to all of them.</p>
		<div class="jumbotron">
			<p class="lead">Everyone has some friends who recommend you which movie you should watch. Eventhough you are not interested in that movies at all.</p><hr class="my-4">
  			<p>Topcorn.io doesn't only understand what you like, it also understands what you don't like!</p>
		</div>
		<p>This page is a hook so you can reach this website. If you want to get the answer of the question immediately, then you can simply skip reading this long post and start using this personalized movie recommendation engine.</p>
		<div class="jumbotron">
			<p class="lead">Start using Topcorn.io to get movie recommendations according to your unique movie taste now.</p>
		</div>
		<p>You can create an account with your facebook account or with your email address easily and quickly. You don’t even have to confirm your email address. If it is still too much work to do, you can just go to the recommendations page and define your mood with several movies and get your movie suggestions according to that mood. However it can be told that, creating a strong profile and filtering the results afterwards is more effective than defining the mood with several movies.</p>
		<div class="jumbotron">
			<p class="lead">creating a strong profile and filtering the results afterwards is more effective than defining the mood with several movies. Create and strengthen your profile quickly! It is <strong>completely free</strong> and it will stay like that! </p>
		</div>
	</div>
</div>
@endsection

