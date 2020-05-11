<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="{{ asset('vendor/cms/css/app.css') }}">
    </head>

    <body>
        <div class="container" id="cms-app">
            <div class="row justify-content-center align-items-center" style="height: 100vh;">
                <div class="col-auto" style="width: 400px">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>
