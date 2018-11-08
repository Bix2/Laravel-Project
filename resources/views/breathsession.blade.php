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
        <h3>Let's take a minute</h3>
        <p>Find a quiet area to breath deeply</p> 
        <div id="breath_session">
            <div class="breath__container" style="">
                <div class="breath__animation" style=""></div>
            </div>
            <form>
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <button class="btn" id="breath_session__buttton">Start a breathing session</button>
            </form>
            <div id="breathingdone"></div>
        </div>
        
    </div>
</div>
@endsection