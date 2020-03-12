<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link href="https://fonts.googleapis.com/css?family=Montserrat|Poppins&display=swap" rel="stylesheet">

        {{-- TODO: Should come from vendor folder of application. --}}
        <link rel="stylesheet" href="/src/public/css/app.css">
    </head>

    <body class="bg-light">
        <div id="cms-app">
            @include('cms::components.header')

            @include('cms::components.sidebar')

            <main class="main-container px-3">
                <div class="container">
                    @yield('content')
                </div>
            </main>
        </div>

        {{-- <script type="text/javascript" src="{{ asset('vendor/cms/js/app.js') }}"></script> --}}
    </body>
</html>
