<div class="sidemenu">     
	<div class="panel">
	
		<div class="panel__content">
			<div class="profile container">
				<div class="row">
					<div class="profile__picture col-4">
						<a href="/profile"><img alt="profile picture of {{ $user->name }}" class="" src="{{$user->avatar}}"></a>
					</div>
					<div class="profile__welcome col-8">
						<p>Hello, {{ $user->name }}</p>
					</div>
				</div>
			</div>
			
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

			<h5 class="panel__title">User</h5>
			<ul class="panel__list">
				<li class="habit-tile">
					<a class="habit-tile__item" href="/profile">
						<span class="icon"><img src="../../images/profile.svg" alt="dashboard icon"></span>
						<span class="link-text">Profile</span>
					</a>
				</li>
				<li class="habit-tile">
					<form action="/logout" method="post">
						{{ csrf_field() }}
						<button class="habit-tile__item">
							<span class="icon"><img src="../../images/logout.svg" alt="dashboard icon"></span>
							<span class="link-text">Log out</span>
						</button>
					</form>
				</li>
			</ul>
			@if($user->admin == 1)
			<h5 class="panel__title">Admin</h5>
			<ul class="panel__list">
				<li class="habit-tile">
					<a class="habit-tile__item" href="/admin">
						<span class="icon"><img src="../../images/profile.svg" alt="dashboard icon"></span>
						<span class="link-text">Statistics</span>
					</a>
				</li>
			</ul>
			@endif

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