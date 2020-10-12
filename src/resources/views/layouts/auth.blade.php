<!doctype html>
<html lang="en">
    @include('cms::components.head')

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
