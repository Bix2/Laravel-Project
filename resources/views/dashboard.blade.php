@extends('layouts.default') 
@section('content')

<div class="row">
	<div class="col-12" id="dash">
        <h2>Dashboard</h2>
    </div>
    @if ($userGoalsAchieved == true)
    <div class="col-12 mt-5">
        <h4>You have achieved all your goals for today. How are you feeling?</h4>
        <div class="card">
            <form id="moodFeedback" method="post" action="/dashboard">
                {{ csrf_field() }}
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="bad" name="mood" value="bad">
                    <label class="form-check-label" for="mood">Bad &#x1F614;</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="neutral" name="mood" value="neutral">
                    <label class="form-check-label" for="mood">Neutral &#x1F610;</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="good" name="mood" value="good">
                    <label class="form-check-label" for="mood">Good &#x1F917;</label>
                </div>
                <button type="submit" class="btn btn-success">Send</button>
            </form>
        </div>
    </div>
    @endif
	<div class="col-12 main__content">
            @if ($trackedHabits[0])
            <div id="app" class="row">  
                @foreach ($trackedHabits[0] as $habit)
                    <div class="col-lg-6 mt-3">
                        <h4 class="d-inline-block"> {{ $habit->short_description }} - </h4>
                        @if($habit->watch == true)
                        <div style="width: 20px" class="tooltip-items d-inline-block" data-toggle="tooltip" data-placement="top" title="Log data by using the Fitbit watch">
                            <img src="images/fitbit-watch.svg" alt="watch">
                        </div>
                        @endif
                        @if($habit->fitbit_app == true) 
                        <div style="width: 20px" class="tooltip-items d-inline-block" data-toggle="tooltip" data-placement="top" title="Log data by using the Fitbit App or Website">
                            <img src="images/smartphone.svg" alt="fitbit app">
                        </div>
                        @endif
                        @if($habit->codebreak == true) 
                        <div style="width: 20px" class="tooltip-items d-inline-block" data-toggle="tooltip" data-placement="top" title="Log data by using this Codebreak app">
                            <img src="images/website.svg" alt="codebreak app">
                        </div>
                        @endif
                        <!-- <a href="/dashboard/{{$habit->type}}">See progress</a> -->
                        @if ($habit->type == "sleep")
                            <div class="alert alert-{{$userProgress['sleep_progress']['status']}}" role="alert">
                                <p class="alert--message">{{$userProgress['sleep_progress']['message']}}</p>
                                <a href="#" class="alert__close">x</a>
                            </div>
                            <a href="/dashboard/{{$habit->type}}">
                                <daysleepchart></daysleepchart>
                            </a>
                        @elseif ($habit->type == "breathing")
                            <div class="alert alert-{{$userProgress['breathing_progress']['status']}}" role="alert">
                                @if($userProgress['breathing_progress']['status'] == 'warning')
                                <p class="alert--message">{{$userProgress['breathing_progress']['message']}} <a href="/dashboard/breathing/session" class="alert--button btn btn-outline-dark">Get started</a></p>
                                @else
                                <p class="alert--message">{{$userProgress['breathing_progress']['message']}}</p>
                                @endif
                                <a href="#" class="alert__close">x</a>
                            </div>
                            <a href="/dashboard/{{$habit->type}}">
                                <daydonutbreathingchart></daydonutbreathingchart>
                            </a>
                        @elseif ($habit->type == "exercise")
                            <div class="alert alert-{{$userProgress['steps_progress']['status']}}" role="alert">
                                @if($userProgress['steps_progress']['message'] == 'warning')
                                <p class="alert--message">{{$userProgress['steps_progress']['message']}} <a href="/dashboard/exercise" class="alert--button btn btn-outline-dark">Log your progress</a></p>
                                @else
                                <p class="alert--message">{{$userProgress['steps_progress']['message']}}</p>
                                @endif
                                <a href="#" class="alert__close">x</a>
                            </div>
                            <a href="/dashboard/{{$habit->type}}">
                                <apexcharts></apexcharts>
                            </a>
                        @elseif ($habit->type == "water")
                            <div class="alert alert-{{$userProgress['water_progress']['status']}}" role="alert">
                                @if($userProgress['water_progress']['status'] == 'warning')
                                <p class="alert--message">{{$userProgress['water_progress']['message']}} <a href="/dashboard/water" class="alert--button btn btn-outline-dark">Log water</a></p>
                                @else
                                <p class="alert--message">{{$userProgress['water_progress']['message']}}</p>
                                @endif
                                <a href="#" class="alert__close">x</a>
                            </div>
                            <a href="/dashboard/{{$habit->type}}">
                                <daydonutwaterchart></daydonutwaterchart>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
            @endif

            @if ($trackedHabits[1])
            <div class="row">
                <div class="col-12">
                    <h4>Start your journey by tracking some of our habits</h4>
                    <div class="row">
                        @foreach ($trackedHabits[1] as $habit)
                        <div class="col-lg-6 mt-3">
                            <div class="card">
                                <div class="card__image">
                                    <img src="images/{{$habit->type}}-dark.svg" alt="{{$habit->type}}">
                                </div>
                                <div class="card__text">
                                    <h5>{{ $habit->short_description }}</h5>
                                    <p>You can log data to this habit by using one of the following:</p>
                                </div>
                                <div class="row">
                                    @if($habit->watch == true)
                                    <div class="col card__items">
                                        <img src="images/fitbit-watch.svg" alt="watch">
                                        <p><a>Fitbit Watch</a></p>
                                    </div>
                                    @endif
                                    @if($habit->fitbit_app == true) 
                                    <div class="col card__items">
                                        <img src="images/smartphone.svg" alt="fitbit app">
                                        <p><a href="https://www.fitbit.com/">Fitbit App</a></p>
                                    </div>
                                    @endif
                                    @if($habit->codebreak == true) 
                                    <div class="col card__items">
                                        <img src="images/website.svg" alt="codebreak app">
                                        <p><a>Codebreak</a></p>
                                    </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="mt-2 col-12">
                                        <form method="post" action="/dashboard/{{$habit->type}}">
                                            {{csrf_field()}}
                                            <button type="sumbit" class="w-100 btn btn-success">Track habit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
    </div>
</div>
@endsection