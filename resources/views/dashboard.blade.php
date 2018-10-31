@extends('layouts.default') 
@section('content')

<div class="row">
	<div class="col-12" id="dash">
		<div class="row">
			<div class="top__content col-8">
				<h2>Dashboard</h2>
				<p>Welcome to CodeBreak dashboard</p>
			</div>
			<div class="col-4 top__content profile__picture">
                <div class="profile__picture--wrapper">
                    <img alt="profile picture of {{ $user->name }}" class="" src="{{$user->avatar}}"></div>
                <div class="profile__name">
                    <p>{{ $user->name }}</p>
                </div>
			</div>
		</div>
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
            @if ($trackedHabitsArray)
            <div class="row">  
                @foreach ($trackedHabitsArray as $habit)
                    <div class="col-12">
                        <h4> {{ $habit->short_description }} </h4>
                        <!-- <a href="/dashboard/{{$habit->type}}">See progress</a> -->
                        @if ($habit->type == "sleep")
                            <div id="app" class="row">
                                <div class="col-8">
                                    <weeksleepchart></weeksleepchart>
                                </div>
                                <div class="col-4">
                                    <daysleepchart></daysleepchart>
                                </div>
                            </div>
                        @elseif ($habit->type == "water")
                            <div class="goal_progress_bar">
                                <div class="goal_progress_bar_progress" style="width: {{$trackedHabitsInfo['userwater']/$trackedHabitsInfo['watergoal']*100}}%; background-color: @if ( ($trackedHabitsInfo['userwater']/$trackedHabitsInfo['watergoal']*100) < 25 )
                                #E51C23
                                @elseif ( ($trackedHabitsInfo['userwater']/$trackedHabitsInfo['watergoal']*100) < 50 )
                                #FF9800
                                @elseif ( ($trackedHabitsInfo['userwater']/$trackedHabitsInfo['watergoal']*100) < 75 )
                                #FFEB3B
                                @else
                                #259B24
                                @endif
                                ">
                                </div>
                                <div class="goal_progress__progress_text"> {{$trackedHabitsInfo['userwater']}} out of {{$trackedHabitsInfo['watergoal']}}</div>
                                
                            </div>
                        @elseif ($habit->type == "exercise")
                            <div class="goal_progress_bar">
                                <div class="goal_progress_bar_progress" style="width: {{$trackedHabitsInfo['usersteps']/$trackedHabitsInfo['stepsgoal']*100}}%; background-color: @if ( ($trackedHabitsInfo['usersteps']/$trackedHabitsInfo['stepsgoal']*100) < 25 )
                                #E51C23
                                @elseif ( ($trackedHabitsInfo['usersteps']/$trackedHabitsInfo['stepsgoal']*100) < 50 )
                                #FF9800
                                @elseif ( ($trackedHabitsInfo['usersteps']/$trackedHabitsInfo['stepsgoal']*100) < 75 )
                                #FFEB3B
                                @else
                                #259B24
                                @endif
                                ">
                                </div>
                                <div class="goal_progress__progress_text"> {{$trackedHabitsInfo['usersteps']}} out of {{$trackedHabitsInfo['stepsgoal']}}</div>
                                
                            </div>
                        @elseif ($habit->type == "breathing")
                            <a href="/dashboard/breathing/session">Start guided breathing session</a>
                        @endif
                    </div>
                @endforeach
            </div>
            @endif

            @if ($untrackedHabitsArray)
                <h3>Untracked habits:</h3>
                <div class="row">
                    @foreach ($untrackedHabitsArray as $habit)
                        <div class="main__container--habit">
                            <h4> {{ $habit->short_description }} </h4>
                            <a href="/dashboard/{{$habit->type}}">See progress</a>
                            @if ($habit->type == "sleep")
                                <!-- Something -->
                            @elseif ($habit->type == "water")
                                <!-- Something -->
                            @elseif ($habit->type == "exercise")
                                <!-- Something -->
                            @elseif ($habit->type == "breathing")
                                <!-- Something -->
                                <a href="/dashboard/breathing/session">Start guided breathing session</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
    </div>
</div>
@endsection