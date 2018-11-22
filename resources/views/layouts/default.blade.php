<!doctype html>
<html>
    <head>
        @include('includes.head')
    </head>
    <body>

        <div class="container">
            @include('includes.header')
            <div class="wrapper">
                <div id="nav">
                    @include('includes.nav')
                </div>
                <div id="main">
                    @yield('content')
                </div>
            </div>
        </div>

        <footer class="footer">
            @include('includes.footer')
        </footer>

    </body>
</html>
