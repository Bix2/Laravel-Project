@extends('layouts.default')
@section('content')
    <div class="container">
        <div class="row">
             <div class="col-8">
                <img src= "{{ $user->avatar }}">
                <p>{{$user->name}}</p>
                <h2> Dashboard </h2>
                {{ dd($user) }}
            </div>
        </div>
    </div>
@stop
