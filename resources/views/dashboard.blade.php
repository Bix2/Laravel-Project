@extends('layouts.default') 
@section('content')

<div class="row">
	<div class="col-12" id="dash">
        <h2>Dashboard</h2>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">How are you feeling?</div>
            <div class="card-body">
                <form id="moodFeedback" method="post" action="/dashboard">
                    {{ csrf_field() }}
                    <h3>How are you feeling?</h3>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="bad" name="mood" value="bad">
                        <label class="form-check-label" for="mood">Bad &#x1F614;</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="neutral" name="mood" value="neutral">
                        <label class="form-check-label" for="mood">Neutral &#x1F610;</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="good" name="mood" value="good">
                        <label class="form-check-label" for="mood">Good &#x1F917;</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
	<div class="col-12 main__content">
            @if ($trackedHabits[0])
            <div id="app" class="row">  
                @foreach ($trackedHabits[0] as $habit)
                    <div class="col-12">
                        <h4> {{ $habit->short_description }} </h4>
                        <!-- <a href="/dashboard/{{$habit->type}}">See progress</a> -->
                        @if ($habit->type == "sleep")
                            <div class="row">
                                <div class="col-8">
                                    <weeksleepchart></weeksleepchart>
                                </div>
                                <div class="col-4">
                                    <daysleepchart></daysleepchart>
                                </div>
                            </div>
                        @elseif ($habit->type == "breathing")
                            <div class="row">
                                <div class="col-12">
                                    <daybreathingchart></daybreathingchart>
                                </div>
                            </div>
                        @elseif ($habit->type == "exercise")
                            <div class="row">
                                <div class="col-4">
                                    <apexcharts></apexcharts>
                                </div>
                                <div class="col-8">
                                    <weekactivitychart></weekactivitychart>
                                </div>
                            </div>
                        @elseif ($habit->type == "water")
                            <div class="row">
                                <div class="col-12">
                                    <daywaterchart></daywaterchart>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            @endif

            @if (empty($trackedHabits[0]))
            <div class="row">
                <div class="col-12">
                    <h4>Start track some habits</h4>
                </div>
            </div>
            @endif
    </div>
</div>
@endsection