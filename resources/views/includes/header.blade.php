<header class="main__header">
    <div class="row">
        <div class="logo__cointainer col-3">
            <a class="logo__container__link" href="#">
                <img class="main__logo" src="/images/logo.svg" alt="Code Break logo">
            </a>
        </div>

        <ul class="nav col-6">
				<li class="nav-item">
					<a class="nav-link active" href="/dashboard">
						<span class="icon"><img src="../../images/dashboard.svg" alt="dashboard icon"></span>
						<span class="link-text">Dashboard</span>
					</a>
				</li>
				@if($user->admin == 1)
				<li class="nav-item">
					<a class="nav-link" href="/admin">
						<span class="icon"><img src="../../images/profile.svg" alt="dashboard icon"></span>
						<span class="link-text">Admin</span>
					</a>
				</li>
				@endif
				<li class="nav-item">
					<a class="nav-link" href="/profile">
						<span class="icon"><img src="../../images/profile.svg" alt="dashboard icon"></span>
						<span class="link-text">Profile</span>
					</a>
				</li>
			</ul>

        <div class="col-3 profile__picture">
            <div class="profile__picture--wrapper">
                <a href="/profile"><img alt="profile picture of {{ $user->name }}" class="" src="{{$user->avatar}}"></a>
            </div>
        </div>
    </div>
</header>