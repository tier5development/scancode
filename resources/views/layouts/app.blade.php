<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="fb-version" content="{{ config("services.facebook.api_version") }}">
        <meta name="fb-auth" content="{{ route('facebook.auth') }}">
        <meta name="scancode" content="{{ route('scancode.store') }}">

        <title>{{ config('app.name') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="fb-root"></div>
        <script async defer src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v{{ config("services.facebook.api_version") }}&appId={{ config("services.facebook.client_id") }}&autoLogAppEvents=1"></script>
        <div id="app">
            <main class="py-4">
                @yield('content')
            </main>
        </div>
        <script>
            window.fbAsyncInit = function() {
                FB.init({
                    appId      : '{{ config("services.facebook.client_id") }}',
                    cookie     : true,
                    xfbml      : true,
                    version    : 'v{{ config("services.facebook.api_version") }}'
                });

                FB.AppEvents.logPageView();

                window.FB = FB;
            };

            (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = "https://connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        @yield('scripts')
    </body>
</html>
