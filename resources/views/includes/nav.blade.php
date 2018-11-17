
<ul class="nav flex-column">
    <li class="nav-item nav-item--title">
        <p>User Panel</p>
    </li>
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
    <!-- check if habits are tracked and list them on page -->
    @if ($trackedHabits[0])
        <li class="nav-item nav-item--title">
            <p>Tracked Habits</p>
        </li>
        @foreach ($trackedHabits[0] as $habit)
            @if ($habit->type == "sleep")
            <li class="nav-item">
                <a class="nav-link active" href="/dashboard/sleep">
                    <span class="icon"><img src="../../images/sleep.svg" alt="dashboard icon"></span>
                    <span class="link-text">Sleep</span>
                </a>
            </li>
            @elseif ($habit->type == "breathing")
            <li class="nav-item">
                <a class="nav-link active" href="/dashboard/breathing">
                    <span class="icon"><img src="../../images/breathing.svg" alt="dashboard icon"></span>
                    <span class="link-text">Breathing</span>
                </a>
            </li>
            @elseif ($habit->type == "exercise")
            <li class="nav-item">
                <a class="nav-link active" href="/dashboard/exercise">
                    <span class="icon"><img src="../../images/steps.svg" alt="dashboard icon"></span>
                    <span class="link-text">Activity</span>
                </a>
            </li>
            @elseif ($habit->type == "water")
            <li class="nav-item">
                <a class="nav-link active" href="/dashboard/water">
                    <span class="icon"><img src="../../images/water.svg" alt="dashboard icon"></span>
                    <span class="link-text">Hydrate</span>
                </a>
            </li>
            @endif
        @endforeach
    @endif

    @if ($trackedHabits[1])
        <li class="nav-item nav-item--title">
            <p>Untracked Habits</p>
        </li>
        @foreach ($trackedHabits[1] as $habit)
            @if ($habit->type == "sleep")
            <li class="nav-item">
                <a class="nav-link active" href="/dashboard/sleep">
                    <span class="icon"><img src="../../images/sleep.svg" alt="dashboard icon"></span>
                    <span class="link-text">Sleep</span>
                </a>
            </li>
            @elseif ($habit->type == "breathing")
            <li class="nav-item">
                <a class="nav-link active" href="/dashboard/breathing">
                    <span class="icon"><img src="../../images/breathing.svg" alt="dashboard icon"></span>
                    <span class="link-text">Breathing</span>
                </a>
            </li>
            @elseif ($habit->type == "exercise")
            <li class="nav-item">
                <a class="nav-link active" href="/dashboard/exercise">
                    <span class="icon"><img src="../../images/steps.svg" alt="dashboard icon"></span>
                    <span class="link-text">Activity</span>
                </a>
            </li>
            @elseif ($habit->type == "water")
            <li class="nav-item">
                <a class="nav-link active" href="/dashboard/water">
                    <span class="icon"><img src="../../images/water.svg" alt="dashboard icon"></span>
                    <span class="link-text">Hydrate</span>
                </a>
            </li>
            @endif
        @endforeach
    @endif
</ul>