<div class="navbar">
    <div class="navbar-inner">
        <a id="logo" href=""></a>
        <nav class="nav">
            <div class="nav__avatar"> 
                <img src= {{ $user->avatar }} >
            </div>
            <div class="nav__username">
               <p> {{ $user->name }} </p>
            </div>
        </nav>
    </div>
</div>