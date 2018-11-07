<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body class="welcome-page">

            <div class="welcome_wrapper">
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
        </div>
        <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
        <script src="/js/welcome.js" ></script>
</body>
</html>
