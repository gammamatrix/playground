<?php
$user = Auth::user();
$role = $user ? $user->role : 'guest';
$name = $user ? $user->name : '';
// dd([
//     '__METHOD__' => __METHOD__,
//     '__FILE__' => __FILE__,
//     '__LINE__' => __LINE__,
//     '$user' => $user,
// ]);
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">{{ config('app.name')}}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="{{route('sitemap')}}">Sitemap</a>
                </li> -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Session
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @guest
                        <li><a class="dropdown-item" href="/login">Login</a></li>
                        @else
                        <li>
                            <div class="dropdown-item">
                            {{ $name }}
                            </div>
                        </li>
                        <li><a class="dropdown-item" href="{{route('dashboard')}}">Dashboard</a></li>
                        @endguest
                        <li>
                            <a class="dropdown-item" href="{{ route('theme', ['appTheme' => 'bootstrap-dark', '_return_url' => request()->url()])}}">
                                <i class="fa-solid fa-moon"></i>
                                Dark Theme
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('theme', ['appTheme' => 'bootstrap', '_return_url' => request()->url()])}}">
                                <i class="fa-solid fa-sun"></i>
                                Light Theme
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/logout">Logout</a></li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>
