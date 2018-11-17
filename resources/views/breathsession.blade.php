@extends('layouts.default')
@section('content')

<div class="row">
    <div class="col-12">
        
        <div class="breathing__wrapper">
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
                <div id="breathingdone">
                    <p>✔️ Session complete!</p>
                    <a class="btn btn-primary" href="/dashboard">Back to dashboard</a>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection