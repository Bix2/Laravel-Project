@extends('layouts.default')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="top__content col-8">
                <h2>My Dashboard</h2>
                <p>Welcome to CodeBreak dashboard</p>
            </div>

            <div class="col-4 top__content profile__picture">
                <div class="row">
                    <div class="col-4 profile__picture--wrapper">
                        <img class="" src="{{ $user->avatar }}" alt="profile picture of {{ $user->name }}">
                    </div>
                    <div class="col-8">
                        <p>{{ $user->name }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row main__content">
            @if(!empty($activeHabits))
                <div class="col-12">
                    <h3>Habits Tracked</h3>
                    @foreach( $activeHabits as $habit )
                        <div>
                            <h4>{{ $habit['title'] }}</h4>
                            <a href="#">See Progress</a>
                        </div>
                    @endforeach
                </div>
            @endif
            @if(!empty($inactiveHabits))
                <div class="col-12">
                    <h3>Habits To Track</h3>
                    @foreach( $inactiveHabits as $habit )
                        <div>
                            <h4>{{ $habit['title'] }}</h4>
                            <a href="#">Track this habit</a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection