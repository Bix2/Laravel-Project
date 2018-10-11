@extends('layouts.default') 
@section('content')
<div class="row">
    <div class="col-12" id="dash">
        <div class="row">
            <div class="top__content col-8">
                <h2>User settings</h2>
                <p>Welcome to CodeBreak dashboard</p>
            </div>
            <div class="col-4 top__content profile__picture">
                <div class="profile__picture--wrapper"></div>
                <div class="profile__name">
                    <p></p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 main__content">
        <div class="row">
            <div class="user__profile">
                <div class="group">
                    <label>Name</label>
                
                </div>
                <div class="group">
                    <label>Age</label>
            
                </div>
                <div class="group">
                    <label>Weight</label>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection