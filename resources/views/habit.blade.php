@extends('layouts.default')
@section('content')

<div class="row" id="app">
    <div class="col-12">
        <a class="btn btn-success" href="/dashboard"><i class="fa fa-arrow-left"></i>
            Back</a>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="top__content col-8">
                <h2>{{ $habit->short_description }}</h2>
                <p>{{ $habit->long_description}}</p>
            </div>
        </div>

        <!-- Start Table -->
        @if ( ($habit->id) == 1 )
        <div class="table-sleep table-striped habit_table">
        @else
        <div class="table table-striped habit_table">
        @endif
        
        <!-- Sleep habit -->
        @if ( ($habit->id) == 1 )
            <div class="thead-dark thead-dark--sleep">
            @if ( $sleepdata['sleeptotal'] > 0 )
                    <div>Type</div>
                @for ($d = -6; $d <= -1; $d++)
                    <div>{{date('D', strtotime($d.' days'))}}</div>
                @endfor
                <div>Today</div>
            </div>
            <div class="tbody-light tbody-light--sleep">
                    <div>Deep sleep</div>
                @foreach ($sleepdata['sleepweek']["deep_minutes"] as $sleepday)
                    <div><strong>{{$sleepday}}</strong> min</div>
                @endforeach
            </div>
            <div class="tbody-dark tbody-dark--sleep">
                    <div>Light sleep</div>
                @foreach ($sleepdata['sleepweek']["light_minutes"] as $sleepday)
                    <div><strong>{{$sleepday}}</strong> min</div>
                @endforeach
            </div>
            <div class="tbody-light tbody-light--sleep">
                    <div>REM sleep</div>
                @foreach ($sleepdata['sleepweek']["rem_minutes"] as $sleepday)
                    <div><strong>{{$sleepday}}</strong> min</div>
                @endforeach
            </div>
            <div class="tbody-dark tbody-dark--sleep">
                    <div>Awake</div>
                @foreach ($sleepdata['sleepweek']["wake_minutes"] as $sleepday)
                    <div><strong>{{$sleepday}}</strong> min</div>
                @endforeach
            @else
            </div>
            <p class="habit_nodata">You didn't track any sleep yet 😢</p>
            @endif
            </div>
        @endif

        <!-- Water habit -->
        @if ( ($habit->id) == 4 )
            @if ( $waterdata['watertotal'] > 0 )
            <div class="thead-dark">
                @for ($d = -6; $d <= -1; $d++)
                    <div>{{date('D', strtotime($d.' days'))}}</div>
                @endfor
                <div>Today</div>
            </div>
            <div class="tbody-light">
                @foreach ($waterdata['waterweek'] as $waterday)
                    <div><strong>{{$waterday}}</strong> ml</div>
                @endforeach
            </div>
            @else
                <p class="habit_nodata">You didn't add any drink yet 😢</p>
            @endif
            <addwater></addwater>
        @endif
                
        <!-- Breathing habit -->
        @if ( ($habit->id) == 2 )
            @if ( $breathingdata['breathingtotal'] > 0 )
            <div class="thead-dark">
                @for ($d = -6; $d <= -1; $d++)
                    <div>{{date('D', strtotime($d.' days'))}}</div>
                @endfor
                <div>Today</div>
            </div>
            <div class="tbody-light">
                @foreach ($breathingdata['breathingweek'] as $breathingday)
                    @if($breathingday == 1)
                        <div><strong>{{$breathingday}}</strong> session</div>
                    @else
                        <div><strong>{{$breathingday}}</strong> sessions</div>
                    @endif
                @endforeach
            </div>
            @else
                <p class="habit_nodata">You didn't do any breahting sessions 😢 <a href="/dashboard/breathing/session">Get started now</a></p>
            @endif
        @endif
                
        <!-- Activity habit -->
        @if ( ($habit->id) == 3 )
            @if ( $stepsdata['stepstotal'] > 0 )
            <div class="thead-dark">
                @for ($d = -6; $d <= -1; $d++)
                    <div>{{date('D', strtotime($d.' days'))}}</div>
                @endfor
                <div>Today</div>
            </div>
            <div class="tbody-light">
                @foreach ($stepsdata['stepsweek'] as $stepsday)
                    <div><strong>{{$stepsday}}</strong> steps</div>
                @endforeach
            </div>
            @else
                <p class="habit_nodata">You didn't track any steps 😢</p>
            @endif
        @endif
        
        <!-- End Table -->
        </div>

        @if (($habit->id == 1))
        <div class="row">
            <div class="col-lg-12 mt-5">
                <h4> Your weekly sleep pattern </h4>
                <weeksleepchart></weeksleepchart>
            </div>
        </div>
        @endif

        @if (($habit->id == 3))
        <div class="row">
            <div class="col-lg-12 mt-5">
                <h4> Your weekly activity </h4>
                <weekactivitychart></weekactivitychart>
            </div>
        </div>
        @endif

        @if (($habit->id == 2))
        <div class="row">
            <div class="col-lg-12 mt-5">
                <h4> Your daily progress </h4>
                <daybreathingchart></daybreathingchart>
            </div>
        </div>
        @endif

        @if (($habit->id == 4))
        <div class="row">
            <div class="col-lg-12 mt-5">
                <h4> Your daily progress </h4>
                <daywaterchart></daywaterchart>
            </div>
        </div>
        @endif
                                
        <div class="row">
            <div class="col-lg-12 mt-3">
                <h4> You can log data to this habit by using one of the following: </h4>
                <div class="card">
                    <div class="row">
                        @if($habit->watch == true)
                        <div class="col card__items">
                            <img src="../images/fitbit-watch.svg" alt="watch">
                            <p>Fitbit Watch</p>
                        </div>
                        @endif
                        @if($habit->fitbit_app == true) 
                        <div class="col card__items">
                            <img src="../images/smartphone.svg" alt="fitbit app">
                            <p><a href="https://www.fitbit.com/">Fitbit App</a></p>
                        </div>
                        @endif
                        @if($habit->codebreak == true) 
                        <div class="col card__items">
                            <img src="../images/website.svg" alt="codebreak app">
                            <p>Codebreak</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row main__content">
            <div class="col-12">
                <div class="d-inline-block mt-3">
                    <form method="post" action="/dashboard/{{$habit->type}}">
                        {{csrf_field()}}
                        @if ($button['status'] == 'success')
                            <button class="btn btn-success" type="submit">{{ $button['text'] }}</button>
                        @else
                            <button class="btn btn-danger" type="submit">{{ $button['text'] }}</button>
                        @endif
                    </form>
                </div>
                <div class="d-inline-block ml-2 mt-3">
                    @if (($habit->id) == 2)
                        <a class="btn btn-success" href="/dashboard/breathing/session">Start breathing session</a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Activity habit -->
        @if ( ($habit->id) == 3 )

        <!-- Log data to Activities -->
        <div class="row">
            <div class="col-lg-6 mt-5">
                <h4>Log activity data</h4>
                <div class="card">
                    <form method="post" action="/dashboard/exercise/log">
                        {{csrf_field()}}
                        <div>
                            <label for="example-date-input" class="col-12 col-form-label">Date</label>
                            <div class="col-12">
                                <input class="form-control" name="date" type="date" value="" id="example-date-input">
                            </div>
                        </div>
                        <div>
                            <label for="example-time-input" class="col-12 col-form-label">Start Time</label>
                            <div class="col-12">
                                <input class="form-control" name="start" type="time" value="" id="example-time-input">
                            </div>
                        </div>
                        <div>
                            <label for="example-time-input" class="col-12 col-form-label">Duration</label>
                            <div class="col-12">
                                <input class="form-control" name="duration" type="time" value="" id="example-time-input">
                            </div>
                        </div>
                        <div>
                            <label for="example-number-input" class="col-12 col-form-label">Distance (km)</label>
                            <div class="col-12">
                                <input class="form-control" name="distance" type="number" value="" id="example-number-input">
                            </div>
                        </div>
                        @if ($errors->any())
                            <div class="m-3 alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class="mt-3">
                            <div class="col-12">
                                <input type="submit" class="btn btn-success form-control" type="number" value="Log Activity">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change goal -->
            <div class="col-lg-6 mt-5">
                <h4>Change activity goal</h4>
                <div class="card">
                    <form method="post" action="/dashboard/exercise/changegoal">
                        {{csrf_field()}}
                        <div>
                            <label for="example-date-input" class="col-12 col-form-label">Goal</label>
                            <div class="col-12">
                                <input class="form-control" name="goal" type="number" value="{{$stepsgoal}}" id="goal">
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="col-12">
                                <input class="btn btn-success form-control" type="submit" value="Change Goal">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
        @endif
    </div>
</div>
@endsection