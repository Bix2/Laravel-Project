<nav>
    <div class="logo"></div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="/dashboard">
                <span class="icon"><img src="../../img/dash.svg" alt="dashboard icon"></span>
                <span class="link-text">Dashboard</span>
            </a>
        </li>
        @if($user->admin == 1)
        <li class="nav-item">
            <a class="nav-link" href="/admin">
                <span class="icon"><img src="../../img/profile.svg" alt="dashboard icon"></span>
                <span class="link-text">Admin</span>
            </a>
        </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" href="/profile">
                <span class="icon"><img src="../../img/profile.svg" alt="dashboard icon"></span>
                <span class="link-text">Profile</span>
            </a>
        </li>
    </ul>
</nav>