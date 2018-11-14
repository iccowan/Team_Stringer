<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Ian Cowan">
        <meta name="propeller" content="a246789773311649a709422984e8ade3">

        <title>@yield('title') | Team Stringer</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Exo">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css">

        <script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js"></script>

        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body>
        @include('layouts.navbar')
        @include('layouts.messages')
        @yield('content')
        <br>
        <center><iframe src="//rcm-na.amazon-adsystem.com/e/cm?o=1&p=48&l=ez&f=ifr&linkID=acc64b8b7c35d618d48b4c87515e61fd&t=teamstringer-20&tracking_id=teamstringer-20" width="728" height="90" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe></center>
        @include('layouts.footer')
    </body>
</html>
