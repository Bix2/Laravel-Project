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

   @if ( $totalsteps >= $stepsgoal )
    <div class="col-8">
        <div class="card">
            <div class="card-header">How are you feeling?</div>
            <div class="card-body">
                <form id="moodFeedback" method="post" action="/dashboard">
                    {{ csrf_field() }}
                    <h3>How are you feeling?</h3>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="bad" name="mood" value="bad">
                        <label class="form-check-label" for="mood">Bad &#x1F614;</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="neutral" name="mood" value="neutral">
                        <label class="form-check-label" for="mood">Neutral &#x1F610;</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="good" name="mood" value="good">
                        <label class="form-check-label" for="mood">Good &#x1F917;</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>  
    @endif

	<div class="col-12 main__content">
            <h3>Tracked habits:</h3>
            <div class="row">  
            @foreach ($trackedhabits as $habit)
                <div class="main__container--habit">
                    <h4> {{ $habit->short_description }} </h4>
                    <a href="/dashboard/{{$habit->type}}">See progress</a>
                    @if ($habit->type == "sssleep")
                        {{ $api->showSleep() }};
                    @elseif ($habit->type == "water")
                        {{ $api->showWater() }};
                    @elseif ($habit->type == "exercise")
                        {{ $api->showSteps() }}
                        <div class="goal_progress_bar">
                            <div class="goal_progress_bar_progress" style="width: {{$totalsteps/$stepsgoal*100}}%; background-color: @if ( ($totalsteps/$stepsgoal*100) < 25 )
                            #E51C23
                            @elseif ( ($totalsteps/$stepsgoal*100) < 50 )
                            #FF9800
                            @elseif ( ($totalsteps/$stepsgoal*100) < 75 )
                            #FFEB3B
                            @else
                            #259B24
                            @endif
                            ">
                             </div>
                             <div class="goal_progress__progress_text"> {{$totalsteps}} out of {{$stepsgoal}}</div>
                            
                        </div>
                        @if ( ($totalsteps/$stepsgoal*100) < 25 )
                            <p class="goal_progress_text">You could go for a walk...</p>
                            @elseif ( ($totalsteps/$stepsgoal*100) < 75 )
                            <p class="goal_progress_text">Come on, you can reach your goal</p>
                            @elseif ( ($totalsteps/$stepsgoal*100) < 100 )
                            <p class="goal_progress_text">Almost there...</p>
                            @else
                            <p class="goal_progress_text">🏁🏁🏁Woohoo! You've reached your goal!</p>
                        @endif
                        <!-- <p class="goal_progress_text"> {{$totalsteps}} out of {{$stepsgoal}}</p> -->
                    @elseif ($habit->type == "breathing")
                        <a href="">Start guided breathing session</a>
                    @endif
                </div>
            @endforeach
            </div>
            <h3>Untracked habits:</h3>
            <div class="row">
            @if ($untrackedhabits)
            @foreach ($untrackedhabits as $habit)
                <div class="main__container--habit">
                    <h4> {{ $habit->short_description }} </h4>
                    <a href="/dashboard/{{$habit->type}}">See progress</a>
                    @if ($habit->type == "sssleep")
                        {{ $api->showSleep() }};
                    @elseif ($habit->type == "water")
                        {{ $api->showWater() }};
                    @elseif ($habit->type == "exercise")
                        {{ $api->showSteps() }};
                    @elseif ($habit->type == "breathing")
                        <a href="">Start guided breathing session</a>
                    @endif
                </div>
            @endforeach
            @else
                <h3>jfvufvn</h3>
            @endif
            </div>
    </div>
</div>
@endsection