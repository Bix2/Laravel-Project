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
                        <h4 class="dailytotal"><span class="dailyamount">{{$total_sleep}}</span> minutes slept today</h4>
                        <ul>
                            <li class="dailytotal"><span class="dailyamount">{{$rem_minutes}}</span> minutes rem sleep</li>
                            <li class="dailytotal"><span class="dailyamount">{{$deep_minutes}}</span> minutes deep sleep</li>
                            <li class="dailytotal"><span class="dailyamount">{{$light_minutes}}</span> minutes light sleep</li>
                        </ul>
                        <h4 class="dailytotal"><span class="dailyamount">{{$dailywater}}</span> liters of water drunk today</h4>
                        <h4 class="dailytotal"><span class="dailyamount">{{$dailybreathing}}</span> breathing sessions done today</h4>
                        <h4 class="dailytotal"><span class="dailyamount">{{$dailysteps}}</span> steps taken today</h4>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>
