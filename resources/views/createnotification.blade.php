@extends('layout.applite')

@include('head.head_whatmovieshouldiwatch')

@section('body')
<div class="row no-gutters">
	<div class="col"></div>
	<div class="col-12 col-lg-10 col-xl-8">
		<div class="d-flex d-row">
			<h1 class="h5 text-center text-md-left col mt-3 mt-md-4 d-inline">Create Notification Panel</h1>
		</div>
	</div>
	<div class="col"></div>
</div>

	@if(session()->has('status'))
    <div class="alert alert-success"> 
    {!! session('status') !!}
    </div>
	@endif

<div class="container-fluid mt-3">
	<div class="row">
		<div class="col"></div>
		<div class="col-12 col-lg-10 col-xl-8">
			<form id="the_form" class="form-horizontal" role="form" method="POST" action="/create_notification">
				{{ csrf_field() }}
				<input type="number" class="d-none" name="list_id" value="{{  $id }}">
				<div class="row mt-3">
					<div class="col-md-3 field-label-responsive">
						<label>en_notification</label>
					</div>
					<div class="col-md-9">
						<div class="">
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<div class="input-group-prepend">
									<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-pencil-alt"></i></div>
								</div>
								<textarea type="text" class="form-control auto-resize" id="entry_1" name="entry_1">{{ $liste != '[]' ? $liste[0]->entry_1 : '' }}</textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-3 field-label-responsive">
						<label>tr_notification</label>
					</div>
					<div class="col-md-9">
						<div class="">
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<div class="input-group-prepend">
									<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-pencil-alt"></i></div>
								</div>
								<textarea type="text" class="form-control auto-resize" id="entry_2" name="entry_2">{{ $liste != '[]' ? $liste[0]->entry_2 : '' }}</textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-3 field-label-responsive">
						<label>hu_notification</label>
					</div>
					<div class="col-md-9">
						<div class="">
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<div class="input-group-prepend">
									<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-pencil-alt"></i></div>
								</div>
								<textarea type="text" class="form-control auto-resize" id="entry_3" name="entry_3">{{ $liste != '[]' ? $liste[0]->entry_3 : '' }}</textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-3 field-label-responsive">
						<label>icon</label>
					</div>
					<div class="col-md-9">
						<div class="">
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<div class="input-group-prepend">
									<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-pencil-alt"></i></div>
								</div>
								<textarea type="text" class="form-control auto-resize" id="entry_4" name="entry_4">{{ $liste != '[]' ? $liste[0]->entry_4 : '' }}</textarea>
							</div>
						</div>
					</div>
				</div>




				<div class="row mt-3">
					<div class="col-md-3 field-label-responsive">
						<label>what to do</label>
					</div>
					<div class="col-md-9">
						<div class="form-group">
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<div class="input-group-prepend">
									<div class="input-group-text" style="width: 2.6rem"><i class="fas fa-sort"></i></div>
								</div>
								<select class="form-control" id="process" name="process">
									<option value="0" {{ $liste != '[]' ? ($liste[0]->sort == 0 ? 'selected' : '') : 'selected' }}>save</option>
									<option value="1" {{ $liste != '[]' ? ($liste[0]->sort == 1 ? 'selected' : '') : '' }}>notificate yourself</option>
									<option value="2" {{ $liste != '[]' ? ($liste[0]->sort == 2 ? 'selected' : '') : '' }}>delete notification</option>
									<option value="3" {{ $liste != '[]' ? ($liste[0]->sort == 3 ? 'selected' : '') : '' }}>!!! PUBLISH NOTIFICATION WITH EVERYONE !!!</option>
								</select>
							</div>
						</div>
					</div>
				</div>

				<!-- Submit -->
				<div class="row mt-5">
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<button type="submit" class="btn btn-primary btn-block">DO IT</button>
					</div>
				</div>
				<!-- Submit -->

			</form>
		</div>
		<div class="col"></div>
	</div>
</div>
@endsection