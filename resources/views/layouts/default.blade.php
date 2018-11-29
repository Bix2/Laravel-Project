<!doctype html>
<html>
    <head>
        @include('includes.head')
    </head>

    <body>
        @include('includes.header')
        <div class="container dash">
            @include('includes.nav')
            <main id="main" class="bmd-layout-content">
                    @yield('content')
            </main> 
        </div>

        <footer class="footer">
            @include('includes.footer')
        </footer>

    </body>
</html>
