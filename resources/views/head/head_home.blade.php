@section('title')
{{ __('title.home') }}
@endsection

@section('meta_description')
Learn what to watch tonight, based on your taste. Filter movies with original language, release year, genre and vote count. Completely free
@endsection

@section('og_tags')
<meta property="og:url" content="{{url('/')}}"/>
<meta property="og:title" content="{{$series_name}} ({{$series_year}})"/>
<meta property="og:description" content="{{$series_plot}}"/>
<meta property="og:type" content="website"/>
<meta property="og:image" content="{{config('constants.image.fb_https')}}{{$poster_path}}"/>
<meta property="fb:app_id" content="{{config('constants.facebook.app_id')}}"/>
@endsection