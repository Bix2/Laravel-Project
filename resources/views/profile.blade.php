@extends('layouts.default') 
@section('content')
<div class="row">
    <div class="col-12" id="profile">
		<div class="row">
			<div class="top__content col-12">
				<h2>Profile</h2>
				<p>Welcome to CodeBreak {{ $user->name }}</p>
			</div>
		</div>
    </div>

    <div class="col-12 main__content">
        <div class="row">
            <div class="col-12 user__profile">
                <div class="group">
                    <label>Name</label>
                    <p>{{ $profile['user']['fullName'] }}</p>
                </div>
                <div class="group">
                    <label>Age</label>
                    <p>{{ $profile['user']['age'] }} years old</p>
                </div>
                <div class="group">
                    <label>Weight</label>
                    <p>{{ $profile['user']['weight'] }} kg</p>
                </div>
                <div class="group">
                    <label>Height</label>
                    <p>{{ $profile['user']['height'] }} cm</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 profile__buttons">
        <div class="row">
            <div class="col-12">
                <form action="/logout" method="post" class="profile__button">
                    {{ csrf_field() }}
                    <button class="btn btn-danger">Log out</button>
                </form>
                <form action="/delete" method="post" class="profile__button">
                    {{ csrf_field() }}
                    <button class="btn btn-danger">Delete Account</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection