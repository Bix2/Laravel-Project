@extends('layouts.default') 
@section('content')

<form-component></form-component> 

<div class="row">
	<div class="col-12" id="dash">
		<div class="row">
			<div class="top__content col-8">
				<h2>Dashboard</h2>
				<p>Welcome to CodeBreak dashboard</p>
                <p class="suggestion">Maybe you can go for a walk?</p>
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
    <form id="moodFeedback" method="post" action="/dashboard">
        {{ csrf_field() }}

        <h3>How are you feeling?</h3>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="good" name="mood" value="good">
            <label class="form-check-label" for="mood">Good &#x1F917;</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="neutral" name="mood" value="neutral">
            <label class="form-check-label" for="mood">Neutral &#x1F610;</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="bad" name="mood" value="bad">
            <label class="form-check-label" for="mood">Bad &#x1F614;</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    
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
                        <p> {{$totalsteps}} out of {{$stepsgoal}}</p>
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