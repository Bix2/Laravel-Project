<header class="main__header">
    <div class="row">
        <div class="logo__cointainer col-6">
            <a class="logo__container__link" href="#">
                <img class="main__logo" src="/images/logo.svg" alt="Code Break logo">
            </a>
        </div>

        <div class="col-6 profile__picture">
            <div class="profile__picture--wrapper">
                <a href="/profile"><img alt="profile picture of {{ $user->name }}" class="" src="{{$user->avatar}}"></a>
            </div>
        </div>
    </div>
</header>