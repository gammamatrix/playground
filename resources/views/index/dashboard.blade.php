@extends($package_config['layout'])
@section('title', 'Dashboard')
@section('breadcrumbs')
<nav aria-label="breadcrumb" class="m-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="/dashboard">Dashboard</a></li>
    </ol>
</nav>
@endsection
