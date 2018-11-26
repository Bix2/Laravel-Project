<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body class="welcome-page">

            <!-- <div class="welcome_wrapper">
            <header class="main__header">
                <div class="row">
                    <div class="logo__cointainer col-6">
                        <a class="logo__container__link" href="#">
                            <img class="main__logo" src="/images/logo.svg" alt="Code Break logo">
                        </a>
                    </div>
                </div>
            </header>
            <div class="welcome__content">
                <div class="welcome_image"></div>
                <div class="welcome_slant"></div>
                <div class="welcome_login">
                    <h2 class="header_tagline">Mindfulness for developers, boost your concentration through habit tracking.</h2>
                    <div class="login-button">
                        <a class="btn btn-primary" href="{{ url("login/fitbit") }}">Login with Fitbit</a>
                        <div class="login__info">All you need is a Fitbit account</div> 
                    </div>
                    
                    <div class="dailystats">
                        <h3>What users have done today</h3>
                        <h4 class="dailytotal"><span class="dailyamount" data-count="{{$total_sleep}}">0</span> minutes slept today</h4>
                        <ul>
                            <li class="dailytotal"><span class="dailyamount" data-count="{{$rem_minutes}}">0</span> minutes rem sleep</li>
                            <li class="dailytotal"><span class="dailyamount" data-count="{{$deep_minutes}}">0</span> minutes deep sleep</li>
                            <li class="dailytotal"><span class="dailyamount" data-count="{{$light_minutes}}">0</span> minutes light sleep</li>
                        </ul>
                        <h4 class="dailytotal"><span class="dailyamount" data-count="{{$dailywater}}">0</span> liters of water drunk today</h4>
                        <h4 class="dailytotal"><span class="dailyamount" data-count="{{$dailybreathing}}">0</span> breathing sessions done today</h4>
                        <h4 class="dailytotal"><span class="dailyamount" data-count="{{$dailysteps}}">0</span> steps taken today</h4>
                    </div>
                </div>
            </div>
        </div> -->
        
        <!-- 
        bg-heart.svg
        bg-sleep.svg
        bg-stats.svg
        home-bg.svg
        home-sec-img.svg
        -->

        <!-- Container -->
        <div class="container-fluid">
            <div class="row">
                <div class="container--bottom col-md-6">
                    <div class="welcome--logo">
                        <img src="/images/logo.svg" alt="codebreak logo">
                    </div>
                    <div class="welcome--text">
                        <h1>Mindfulness for developers</h1>
                        <h5>Boost your concentration through habit tracking. All you need is a FitBit account</h5>
                        <a class="mt-5 btn-lg btn btn-success" href="{{ url('login/fitbit') }}">Login with Fitbit</a>
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
                        <img src="/images/steps.svg" alt="activity habit">
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
