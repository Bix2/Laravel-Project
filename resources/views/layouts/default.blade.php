<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body>

<div class="container">
    <div class="row">
        <header class="col-2 mainHeader">
            @include('includes.header')
        </header>

        <div id="main" class="col-10">

                @yield('content')

        </div>
    </div>
</div>

<footer class="footer">
    @include('includes.footer')
</footer>

</body>
</html>
