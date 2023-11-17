@extends($package_config['layout'])
<?php
$user = Auth::user();
if ($user) {
    $isAdmin = $user->isAdmin();
    $isClient = $user->hasRole('client');
    $isManager = $user->hasRole('manager');
    $isPublisher = $user->hasRole('publisher');
    $isVendor = $user->hasRole('vendor');
    $inSales = $user->hasRole('sales');
    $name = $user->name;
    $role = $user->role;
} else {
    $isAdmin = false;
    $isClient = false;
    $isManager = false;
    $isPublisher = false;
    $inSales = false;
    $isVendor = false;
    $role = 'guest';
    $name = '';
}
$isGuest = empty($role) || in_array($role, [
    'guest',
]);
?>
@section('title', 'Sitemap')
@section('breadcrumbs')
<nav aria-label="breadcrumb" class="m-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('sitemap') }}">Sitemap</a></li>
    </ol>
</nav>
@endsection
@section('content')
<div class="container-fluid">
    <h1>Sitemap</h1>
    <div class="row justify-content-center">

@foreach($sitemaps as $sitemap_package => $sitemap_blade)
@includeWhen((!empty($sitemap_blade['view'])), $sitemap_blade['view'])
@endforeach

    </div>
</div>
@endsection
