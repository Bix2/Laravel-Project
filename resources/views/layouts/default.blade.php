<!doctype html>
<html>
    <head>
        @include('includes.head')
    </head>
    <body>
        @include('includes.header')
        <div class="container dash">
            @include('includes.nav')
            <main id="container" class="bmd-layout-content">
                <div class="container main-overlay">
                    @yield('content')
                </div>
            </main> 
        </div>
        
        <footer class="footer">
            @include('includes.footer')
        </footer>

    </body>
</html>
