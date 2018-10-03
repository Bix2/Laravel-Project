<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body>

<header class="row mainHeader">
    <div class="container">
        @include('includes.header')
    </div>
</header>

<div class="container">

    <div id="main" class="row">

            @yield('content')

    </div>

    <footer class="footer">
        @include('includes.footer')
    </footer>

</div>
</body>
</html>
