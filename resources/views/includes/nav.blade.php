<div class="sidemenu">     
	<div class="panel">
		<div class="panel__content">
			<h5 class="panel__title">Dashboard</h5>
			<ul class="panel__list">
				<li class="habit-tile">
					<a class="habit-tile__item active" href="/dashboard">
						<span class="icon"><img src="../../images/dashboard.svg" alt="dashboard icon"></span>
						<span class="link-text">Daily overview</span>
					</a>
				</li>
			@if ($trackedHabits[1])
			@foreach ($trackedHabits[1] as $habit)
				<li class="habit-tile">
					<a class="habit-tile__item" href="/dashboard/{{$habit->type}}">
						<span class="icon"><img src="../../images/{{$habit->type}}.svg" alt="dashboard icon"></span>
						<span class="link-text">{{$habit->short_description}}</span>
					</a>
				</li>
			@endforeach
			@endif

			@if ($trackedHabits[0])
			@foreach ($trackedHabits[0] as $habit)
					<li class="habit-tile">
						<a class="habit-tile__item" href="/dashboard/{{$habit->type}}">
							<span class="icon"><img src="../../images/{{$habit->type}}.svg" alt="dashboard icon"></span>
							<span class="link-text">{{$habit->short_description}}</span>
						</a>
					</li>
				@endforeach
			@endif
	
			</ul>

		</div>


	</div> 

	<button class="collapseDrawer toggleDrawer">
		<img src="../images/close.svg">
	</button> 

	<button class="expandDrawer toggleDrawer">
		<img src="../images/expand.svg">
	</button>
</div> 
<div class="dash-overlay"></div>