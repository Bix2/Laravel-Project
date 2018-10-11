@extends('layouts.default') 

@section('content')
<div class="row">
	<div class="col-12" id="dash">
		<div class="row">
			<div class="top__content col-8">
				<h2>Admin</h2>
				<p>Check the mood of the users</p>
			</div>
			<div class="col-4 top__content profile__picture">
                <div class="profile__picture--wrapper">
                        <img alt="profile picture of {{ $user->name }}" class="" src="{{$user->avatar}}">
                    <div class="profile__name">
                        <p>{{ $user->name }}</p>
                    </div>
                </div>
            </div>
		</div>
    </div>
</div>
@if ($user->admin == 1)
<div class="col-12 main__content">
    <div class="row">  
    @foreach ($users as $user)
        <div class="col-4">
            <p>{{$user->name}}</p>
        </div>
        <div class="col-4">
            <p>{{$user->type}}</p>
        </div>
        <div class="col-4">
            <p>{{$user->mood}}</p>
        </div>
    @endforeach
    </div>
</div>
@endif
@endsection