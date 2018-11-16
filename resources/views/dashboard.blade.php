@extends('layouts.default') 
@section('content')

<div class="row">
	<div class="col-12" id="dash">
        <h2>Dashboard</h2>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">How are you feeling?</div>
            <div class="card-body">
                <form id="moodFeedback" method="post" action="/dashboard">
                    {{ csrf_field() }}
                    <h3>How are you feeling?</h3>
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
	<div class="col-12 main__content">
            @if ($trackedHabits[0])
            <div id="app" class="row">  
                @foreach ($trackedHabits[0] as $habit)
                    <div class="col-12">
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
                                {{$userProgress['sleep_progress']['message']}}
                                <a href="#" class="alert__close">x</a>
                            </div>
                            <div class="row">
                                <div class="col-lg-8 mt-3">
                                    <weeksleepchart></weeksleepchart>
                                </div>
                                <div class="col-lg-4 mt-3">
                                    <daysleepchart></daysleepchart>
                                </div>
                            </div>
                        @elseif ($habit->type == "breathing")
                            <div class="alert alert-{{$userProgress['breathing_progress']['status']}}" role="alert">
                                {{$userProgress['breathing_progress']['message']}}
                                <a href="#" class="alert__close">x</a>
                            </div>
                            <div class="row">
                                <div class="col-12 mt-3">
                                    <daybreathingchart></daybreathingchart>
                                </div>
                            </div>
                        @elseif ($habit->type == "exercise")
                            <div class="alert alert-{{$userProgress['steps_progress']['status']}}" role="alert">
                                {{$userProgress['steps_progress']['message']}}
                                <a href="#" class="alert__close">x</a>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 mt-3">
                                    <apexcharts></apexcharts>
                                </div>
                                <div class="col-lg-8 mt-3">
                                    <weekactivitychart></weekactivitychart>
                                </div>
                            </div>
                        @elseif ($habit->type == "water")
                            <div class="alert alert-{{$userProgress['water_progress']['status']}}" role="alert">
                                {{$userProgress['water_progress']['message']}}
                                <a href="#" class="alert__close">x</a>
                            </div>
                            <div class="row">
                                <div class="col-12 mt-3">
                                    <daywaterchart></daywaterchart>
                                    <!-- <addwater></addwater> -->
                                </div>
                            </div>
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
                                    <h5>Requirements</h5>
                                    <p>You can log data to this habit by using one of the following:</p>
                                </div>
                                <div class="row">
                                    @if($habit->watch == true)
                                    <div class="col card__items">
                                        <img src="images/fitbit-watch.svg" alt="watch">
                                        <p>Fitbit Watch</p>
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
                                        <p>Codebreak</p>
                                    </div>
                                    @endif
                                </div>
                                <a href="/dashboard/{{$habit->type}}" class="btn btn-success">Visit the habit page</a>
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