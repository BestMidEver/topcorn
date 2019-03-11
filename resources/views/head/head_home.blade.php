@section('title')
{{ __('title.home') }}
@endsection

@section('meta_description')
{{ __('long_texts.home.description') }}
@endsection

@section('og_tags')
<meta property="og:url" content="{{url('/')}}/{{App::getlocale()}}"/>
<meta property="og:title" content="{{ __('long_texts.home.h1') }}"/>
<meta property="og:description" content="{{ __('long_texts.home.description') }}"/>
<meta property="og:type" content="website"/>
<meta property="og:image" content="{{url('/')}}images/examplecard_mac.png"/>
<meta property="fb:app_id" content="{{config('constants.facebook.app_id')}}"/>
@endsection