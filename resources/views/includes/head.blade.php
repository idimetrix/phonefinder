<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

@if(Request::is('phone/*'))
    @include('includes.meta')
@else
    <meta name="keywords" content="phones">
    <meta name="description" content="@yield('meta_description')">
    <title>@yield('title', trans('pages.title_site'))</title>
@endif

@if(Request::is('phone/detailed/*'))
    <meta name="robots" content="noindex">
@endif

<link href="/css/app.css" rel="stylesheet">
<script>
  window.addEventListener("load", function(){
    window.cookieconsent.initialise({
      "palette": {
        "popup": {
          "background": "#237afc"
        },
        "button": {
          "background": "transparent",
          "text": "#fff",
          "border": "#fff"
        }
      },
      "content": {
        "message": "By continue to use the site, you agree to the use of cookies.",
        "dismiss": "Accept",
        "link": "more inforamtion",
        "href": "{{env('APP_URL')}}/privacy_policy"
      }
    })});
</script>