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
@{{page_variables.notification_count>0?'('+page_variables.notification_count+') ':''}}
{{ $liste[0]->title.__('title.list') }}
@endsection

@section('meta_description')
{{$liste[0]->entry_1}}
@endsection

@section('og_tags')
<meta property="og:url" content="{{url('/')}}/list/{{$id}}/{{App::getlocale()}}"/>
<meta property="og:title" content="{{$liste[0]->entry_1}}"/>
<meta property="og:description" content="{{ $liste[0]->entry_1 }}"/>
<meta property="og:type" content="website"/>
<meta property="og:image" content="{{config('constants.image.thumb_nail')[2].$movies[0]->poster_path}}"/>
<meta property="fb:app_id" content="{{config('constants.facebook.app_id')}}"/>
@endsection