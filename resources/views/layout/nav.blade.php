<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <a class="navbar-brand" href="{{route('index')}}">Navbar</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item ">
                <a class="nav-link" href="{{route('index')}}">Начало</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('contact')}}">Контактна форма</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('shop')}}">Магазин</a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown link</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#">Something</a>
                    <a class="dropdown-item" href="#">Пак начало</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>

        </ul>

        <ul class="nav navbar-nav navbar-right">

            @guest
            <li class="nav-item">
                <a class="nav-link" href="{{route('register')}}">Регистрация</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('login')}}">Вход</a>
            </li>
            @endguest

            @auth
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::user()->email}}</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{route('profile')}}">Профил</a>
                    <a class="dropdown-item" href="{{route('cart')}}">Количка</a>

                    @if(Auth::user()->role_id == 1)
                    <a class="dropdown-item" href="{{route('manage_orders')}}">Управление на поръчки</a>
                    @endif

                    <a class="dropdown-item" href="{{route('logout')}}">Изход</a>
                </div>
            </li>
            @endauth
        </ul>

    </div>
</nav>