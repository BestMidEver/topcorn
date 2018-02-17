@extends(Auth::user() ? 'layout.app' : 'layout.appnew')

@include('head.head_donation')

@section('body')
<h5 class="text-center text-md-left col mt-3 mt-md-4">{{ __('navbar.donation') }}</h5>
<button type="button" class="btn btn-lg btn-danger" data-toggle="popover" data-placement="bottom" title="Popover title" data-html="true" data-target="#my-popover-content">Click to toggle popover</button>
<script type="text/html" id="my-popover-content">
    *** HTML CONTENT GOES HERE ***
</script>
<div class="p-3">
	<p class="lead">{{ __('long_texts.donation') }}</p>
</div>

<div class="container-fluid mt-3">
	<ul class="nav justify-content-md-center tab1" ng-init="active_tab='bitcoin'">
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='bitcoin'}" ng-click="active_tab='bitcoin'">{{ __('general.bitcoin') }}</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='ethereum'}" ng-click="active_tab='ethereum'">{{ __('general.ethereum') }}</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='patreon'}" ng-click="active_tab='patreon'">Patreon</button>
		</li>
		<li class="nav-item">
			<button class="btn btn-link nav-link text-muted" ng-class="{'active':active_tab=='bank_transfer'}" ng-click="active_tab='bank_transfer'">{{ __('general.bank_transfer') }}</button>
		</li>
	</ul>
</div>

<div class="jumbotron text-center background-white" ng-show="active_tab=='bitcoin'">
	<div class="row">
		<div class="col-12 col-lg-6">
			<div class="h-100 d-flex flex-column justify-content-center">
				<div>
					<p>{{ __('general.bitcoin_address') }}: <code class="lead">{{ config('constants.money.bitcoin') }}</code></p>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-6 my-5 my-lg-0">
			<div class="h-100 d-flex flex-column justify-content-center">
				<div class="flex-row justify-content-center">
					<img class="img-fluid" src="/images/wallet_address_bitcoin.png">
				</div>
			</div>
		</div>
	</div>
</div>

<div class="jumbotron text-center background-white" ng-show="active_tab=='ethereum'">
	<div class="row">
		<div class="col-12 col-lg-6">
			<div class="h-100 d-flex flex-column justify-content-center">
				<div>
					<p>{{ __('general.ethereum_address') }}: <code class="lead">{{ config('constants.money.ethereum') }}</code></p>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-6 my-5 my-lg-0">
			<div class="h-100 d-flex flex-column justify-content-center">
				<div class="flex-row justify-content-center">
					<img class="img-fluid" src="/images/wallet_address_ethereum.png">
				</div>
			</div>
		</div>
	</div>
</div>

<div class="jumbotron text-center background-white" ng-show="active_tab=='patreon'">
	<div class="row">
		<div class="col">
			<div class="h-100 d-flex flex-column justify-content-center">
				<div class="flex-row justify-content-center">
					<a href="https://www.patreon.com/preview/92803a572d784860924a7c9c7acd8811" target="_blank" class="btn btn-danger">Patreon</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="jumbotron background-white" ng-show="active_tab=='bank_transfer'">
	<div class="row">
		<div class="col">
			<div class="h-100 d-flex flex-column justify-content-center">
				<div>
					<div class="h5">{{ __('general.dollar_account') }}</div>
					<p><span class="text-muted">{{ __('general.recipient_name') }}:</span> Uygar Yılmaz</p>
					<p><span class="text-muted">{{ __('general.country') }}:</span> {{ __('countries.TR') }}</p>
					<p><span class="text-muted">{{ __('general.bank') }}:</span> {{ __('general.bank_') }}</p>
					<p><span class="text-muted">{{ __('general.bank_address') }}:</span> {{ __('general.bank_address_') }}</p>
					<p><span class="text-muted">IBAN:</span> TR 6400 0100 0065 6253 0283 5004</p>
				</div>
			</div>
		</div>
	</div>
	<div class="row mt-4">
		<div class="col">
			<div class="h-100 d-flex flex-column justify-content-center">
				<div>
					<div class="h5">{{ __('general.euro_account') }}</div>
					<p><span class="text-muted">{{ __('general.recipient_name') }}:</span> Uygar Yılmaz</p>
					<p><span class="text-muted">{{ __('general.country') }}:</span> {{ __('countries.TR') }}</p>
					<p><span class="text-muted">{{ __('general.bank') }}:</span> {{ __('general.bank_') }}</p>
					<p><span class="text-muted">{{ __('general.bank_address') }}:</span> {{ __('general.bank_address_') }}</p>
					<p><span class="text-muted">IBAN:</span> TR 5400 0100 1900 6253 0283 5002</p>
				</div>
			</div>
		</div>
	</div>
	<div class="row mt-4">
		<div class="col">
			<div class="h-100 d-flex flex-column justify-content-center">
				<div>
					<div class="h5">{{ __('general.try_account') }}</div>
					<p><span class="text-muted">{{ __('general.recipient_name') }}:</span> Uygar Yılmaz</p>
					<p><span class="text-muted">{{ __('general.country') }}:</span> {{ __('countries.TR') }}</p>
					<p><span class="text-muted">{{ __('general.bank') }}:</span> {{ __('general.bank_') }}</p>
					<p><span class="text-muted">{{ __('general.bank_address') }}:</span> {{ __('general.bank_address_') }}</p>
					<p><span class="text-muted">IBAN:</span> TR 8100 0100 1900 6253 0283 5001</p>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection