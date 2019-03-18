@if(Auth::check())
	@if(Auth::id()==7)
<div class="p-5">
	<p class="h6">An offer that you can't refuse.</p>
	<p>If you liked using Topcorn.io contribute us by signing up Amazon Prime 30-day free trial.</p>
	<p>It is completely free and you can cancel it any time. We will get benefit even if you don't complete the full 30 days.</p>
	<p class="h6">What will you earn if you sign up Amazon Prime</p>
	<p>Instant streaming of thousands of movies and TV shows</p>
	<p>FREE Two-Day Shipping on millions of items</p>
	<p>Unlimited, ad-free access to over a million songs and hundreds of playlists</p>
	<p>Borrow books from the Kindle Owners' Lending Library</p>
</div>
	@endif
@endif