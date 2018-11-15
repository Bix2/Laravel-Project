@extends('layouts.default')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="top__content col-8">
                <h2>{{ $habit->short_description }}</h2>
                <p>{{ $habit->long_description}}</p>
            </div>
        </div>

        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>



                @if ( ($habit->id) == 1 )
                    <th>Type</th>
                @for ($d = -6; $d <= 0; $d++)
                    <th>{{date('D', strtotime($d.' days'))}}</th>
                @endfor
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Deep sleep</td>
                @foreach ($sleepweek["deep_minutes"] as $sleepday)
                    <td>{{$sleepday}}</td>
                @endforeach
                </tr>
                <tr>
                    <td>Light sleep</td>
                @foreach ($sleepweek["light_minutes"] as $sleepday)
                    <td>{{$sleepday}}</td>
                @endforeach
                </tr>
                <tr>
                    <td>REM sleep</td>
                @foreach ($sleepweek["rem_minutes"] as $sleepday)
                    <td>{{$sleepday}}</td>
                @endforeach
                </tr>
                <tr>
                    <td>Awake</td>
                @foreach ($sleepweek["wake_minutes"] as $sleepday)
                    <td>{{$sleepday}}</td>
                @endforeach
                @endif


                @if ( ($habit->id) == 4 )
                
                @for ($d = -6; $d <= 0; $d++)
                    <th>{{date('D', strtotime($d.' days'))}}</th>
                @endfor
                </tr>
            </thead>
            <tbody>
                <tr>
                @foreach ($waterweek as $waterday)
                    <td>{{$waterday}}</td>
                @endforeach
                @endif


                
                @if ( ($habit->id) == 2 )
                
                @for ($d = -6; $d <= 0; $d++)
                    <th>{{date('D', strtotime($d.' days'))}}</th>
                @endfor
                </tr>
            </thead>
            <tbody>
                <tr>
                @foreach ($breathingweek as $breathingday)
                    <td>{{$breathingday}}</td>
                @endforeach
                @endif
                

                @if ( ($habit->id) == 3 )
                
                @for ($d = -6; $d <= 0; $d++)
                    <th>{{date('D', strtotime($d.' days'))}}</th>
                @endfor
                </tr>
            </thead>
            <tbody>
                <tr>
                @foreach ($stepsweek as $stepsday)
                    <td>{{$stepsday}}</td>
                @endforeach
                @endif
                </tr>
            </tbody>
        </table>

        <!-- {{@print_r($habit)}} -->
        <div class="row">
            <div class="col-lg-12 mt-3">
                <h4> You can log data to this habit by using one of the following: </h4>
                <div class="card">
                    <div class="row">
                        @if($habit->watch == true)
                        <div class="col card__items">
                            <img src="../images/fitbit-watch.svg" alt="watch">
                            <p>Fitbit Watch</p>
                        </div>
                        @endif
                        @if($habit->fitbit_app == true) 
                        <div class="col card__items">
                            <img src="../images/smartphone.svg" alt="fitbit app">
                            <p><a href="https://www.fitbit.com/">Fitbit App</a></p>
                        </div>
                        @endif
                        @if($habit->codebreak == true) 
                        <div class="col card__items">
                            <img src="../images/website.svg" alt="codebreak app">
                            <p>Codebreak</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row main__content">
            <div class="col-12 mt-3">
                <form method="post" action="/dashboard/{{$habit->type}}">
                    {{csrf_field()}}
                    @if ($button['status'] == 'success')
                        <button class="btn btn-success" type="submit">{{ $button['text'] }}</button>
                    @else
                        <button class="btn btn-danger" type="submit">{{ $button['text'] }}</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection