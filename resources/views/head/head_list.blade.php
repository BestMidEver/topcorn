@section('passdata')
<script type="text/javascript">
pass={
	"angular_module_array":[],
	"liste":{!! json_encode($liste) !!},
	"movies":{!! json_encode($movies) !!},
	"like_count":"{{ $like_count  }}",
	"is_liked":"{{ $is_liked  }}",
	"is_auth":"{{  Auth::Check()  }}",
	"lang":"{{ App::getlocale() }}",
	@if(Auth::check())
	"tt_navbar":{{ Auth::User()->tt_navbar }},
	"watched_movie_number":{{ $watched_movie_number }}
	@endif
};
</script>
@endsection

@section('angular_controller_js')
<script src="/js/controllers/ListPageController.js?v={{config('constants.version')}}"></script>
@endsection
@section('controllername','ListPageController')

@section('title')
{{ $liste[0]->title.__('title.list') }}
@endsection