@if(Auth::check())
	@if(Auth::id()==7)
<div class="p-5">
	<div class="h6">An offer that you can't refuse.</div>
	<div>If you liked using Topcorn.io contribute us by signing up Amazon Prime 30-day free trial.</div>
</div>
	@endif
@endif