<?php
$user = Auth::user();
$role = $user ? $user->role : 'guest';
$name = $user ? $user->name : '';
?>

@section('nav-banner')
<div class="flex-grow-1 text-center">
    <a class="navbar-brand" href="{{ route('home') }}">
        {{ config('app.name')}}
    </a>
</div>
@endsection

@section('nav-user-menu')

@guest
<div class="dropdown-item">
    <a class="nav-link" href="{{ route('login') }}">Sign in</a>
</div>
@else
<div class="dropdown-item">
    {{ $name }}
</div>
@if (!empty($role) && 'guest' !== $role)
<a class="dropdown-item" href="{{ route('home') }}">
    Home
</a>
@endif
<a class="dropdown-item" href="{{ route('logout', ['redirectTo' => url()->current() ]) }}" onclick="localStorage.clear()">
    Logout
</a>
@endguest

@endsection
