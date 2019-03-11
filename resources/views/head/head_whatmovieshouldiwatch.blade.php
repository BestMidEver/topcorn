@section('title')
What Movie Should I Watch? (2019)
@endsection

@section('meta_description')
Learn what to watch tonight, based on your taste. Filter movies with original language, release year, genre and vote count. Completely free
@endsection

@section('og_tags')
<meta property="og:url" content="{{url('/')}}/home"/>
<meta property="og:title" content="What movie should I watch tonight?"/>
<meta property="og:description" content="Learn what to watch tonight, based on your taste. Filter movies with original language, release year, genre and vote count. Completely free"/>
<meta property="og:type" content="website"/>
<meta property="og:image" content="/images/godfather_feeling.png"/>
<meta property="fb:app_id" content="{{config('constants.facebook.app_id')}}"/>
@endsection

@section('adsense')
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-5818851352711866",
    enable_page_level_ads: true
  });
</script>
@endsection