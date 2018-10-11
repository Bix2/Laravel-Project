@extends('layouts.default') @section('content')
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