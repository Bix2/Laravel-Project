@extends('layouts.default')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="top__content col-8">
                <h2>{{ $habit->short_description }}</h2>
                <p>{{ $habit->long_description}}</p>
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

        {{@print_r($habit)}}

        <div class="row main__content">
            <div class="col-12">
                <form method="post" action="/dashboard/{{$habit->type}}">
                    {{csrf_field()}}
                    <button type="submit">{{ $button['text'] }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection