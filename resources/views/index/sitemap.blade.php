@extends($package_config['layout'])
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
