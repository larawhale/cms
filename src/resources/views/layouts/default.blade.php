<!doctype html>
<html lang="en">
    @include('cms::components.head')

    <body>
        <div id="cms-app">
            @include('cms::components.header')

            @include('cms::components.sidebar')

            <main class="main-container px-3">
                <div class="container">
                    @yield('content')
                </div>
            </main>
        </div>

        <script type="text/javascript" src="{{ asset('vendor/cms/js/app.js') }}"></script>
    </body>
</html>
