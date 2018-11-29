<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body class="welcome-page">

        <div class="container-fluid">
            <div class="row">
                <div class="container--bottom col-md-6">
                    <div class="welcome--logo">
                        <img src="/images/full-logo.svg" alt="codebreak logo">
                    </div>
                    <div class="welcome--text">
                        <h1 class="mb-5">Mindfulness for developers</h1>
                        <h5>Boost your concentration through habit tracking. All you need is a FitBit account</h5>
                        <a class="mt-3 mb-5 btn-lg btn btn-login" href="{{ url('login/fitbit') }}">Login with Fitbit</a>
                    </div>
                    <div class="welcome--text">
                        <p>Dont have an account yet? Sign up now for a free account!</p>
                        <a class="btn-lg btn btn-register" target="_blank" href="https://www.fitbit.com/be/signup">Register</a>
                    </div>
                    <div class="bg-sec"></div>
                </div>
                <div class="container--top col-md-6 p-0">
                    <img class="heart--bg" src="/images/bg-heart.svg" alt="heart stats">
                    <img class="sleep--bg" src="/images/bg-sleep.svg" alt="sleep stats">
                    <img class="stats--bg" src="/images/bg-stats.svg" alt="stats">
                    <div class="bg-img"></div>
                </div>
            </div>

            <div class="dailystats mt-5 mb-5 row">
                <div class="counter--title mb-5 col-12">
                    <h1 class="mb-3">What users have done today</h1>
                </div>
                <div class="welcome--card col-12 col-md-6 col-lg-3">
                    <div class="welcome--icon welcome--purple">
                        <img src="/images/breathing.svg" alt="breathing habit">
                    </div>
                    <h3><span class="dailyamount" data-count="{{$total_sleep}}"><strong>0</strong></span></h3>
                    <h6 class="dailytotal">minutes slept today</h6>
                </div>
                <div class="welcome--card col-12 col-md-6 col-lg-3">
                    <div class="welcome--icon welcome--yellow">
                        <img src="/images/sleep.svg" alt="sleep habit">
                    </div>
                    <h3><span class="dailyamount" data-count="{{$dailywater}}"><strong>0</strong></span></h3>
                    <h6 class="dailytotal">liters of water drunk today</h6>
                </div>
                <div class="welcome--card col-12 col-md-6 col-lg-3">
                    <div class="welcome--icon welcome--pink">
                        <img src="/images/exercise.svg" alt="activity habit">
                    </div>
                    <h3 ><span class="dailyamount" data-count="{{$dailybreathing}}"><strong>0</strong></span></h3>
                    <h6 class="dailytotal">breathing sessions done today</h6>
                </div>
                <div class="welcome--card col-12 col-md-6 col-lg-3">
                    <div class="welcome--icon welcome--blue">
                        <img src="/images/water.svg" alt="water habit">
                    </div>
                    <h3><span class="dailyamount" data-count="{{$dailysteps}}"><strong>0</strong></span></h3>
                    <h6 class="dailytotal">steps taken today</h6>
                </div>
            </div>
            <div class="row">
                <div class="p-5 col-12">
                    <div class="bg-sec2"></div>
                </div>
            </div>
        </div>
    <div class="footer__copyright">© Copyright 2018 Codebreak</div>
    <script
    src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
    <script src="/js/welcome.js" ></script>
</body>
</html>
