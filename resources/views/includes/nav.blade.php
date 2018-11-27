<div class="bmd-layout-container bmd-drawer-f-r bmd-drawer-overlay tileDrawer">     
	<div class="bmd-layout-drawer bg-faded panel">
		@if ($trackedHabits[1])
		<header>
			<a class="panel__title">Add habits to your dashboard</a>
		</header>
		<div class="addDialog">
			<ul class="list-group tileList">
			@foreach ($trackedHabits[1] as $habit)
				@if ($habit->type == "sleep")
					<li class="availableTile sleep">
						<a class="list-group-item" href="/dashboard/sleep">
							<span class="icon"><img src="../../images/sleep.svg" alt="dashboard icon"></span>
							<span class="link-text">Sleep</span>
						</a>
						<div class="checkbox">
							<span class="check"><img src="../../images/checked.svg"></span>
						</div>
					</li>
				@elseif ($habit->type == "breathing")
					<li class="availableTile breathing">
						<a class="list-group-item" href="/dashboard/sleep">
							<span class="icon"><img src="../../images/breathing.svg" alt="dashboard icon"></span> 
							<span class="link-text">Sleep</span>
						</a>
						<div class="checkbox">
							<span class="check"><img src="../../images/checked.svg"></span>
						</div>
					</li>
				@elseif ($habit->type == "exercise")
					<li class="availableTile exercise">
						<a class="list-group-item" href="/dashboard/exercise">
							<span class="icon"><img src="../../images/steps.svg" alt="dashboard icon"></span>
							<span class="link-text">Activity</span>
						</a>
						<div class="checkbox">
							<span class="check"><img src="../../images/checked.svg"></span>
						</div>
					</li>
				@elseif ($habit->type == "water")
					<li class="availableTile water">
						<a class="list-group-item" href="/dashboard/water">
							<span class="icon"><img src="../../images/water.svg" alt="dashboard icon"></span>
							<span class="link-text">Hydrate</span>
						</a>
						<div class="checkbox">
							<span class="check"><img src="../../images/checked.svg"></span>
						</div>
					</li>
				@endif
			@endforeach
			@endif
			</ul>
			<div class="addTiles">
				<span class="addButton">Done</span>
			</div>
		</div> 
	</div> 

    @if ($trackedHabits[0] && !$trackedHabits[1] )
	<div class="noTiles">
		<h2>More coming soon!</h2>
		<p>You have added all tiles we have available</p><span class="dismissDialog">Done</span>
	</div>
	@endif

	<button class="collapseDrawer toggleDrawer">
		<img src="../images/close.svg">
	</button> 

	<button class="expandDrawer toggleDrawer">
		<img src="../images/expand.svg">
	</button>

</div> 