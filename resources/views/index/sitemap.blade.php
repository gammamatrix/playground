@extends($package_config['layout'])
@section('title', 'Sitemap')
@section('breadcrumbs')
    <nav aria-label="breadcrumb" class="m-3">
        <ol class="breadcrumb">
            @if (Route::has('home'))
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">{{ __('Home') }}</a>
                </li>
            @endif
            @if (Route::has('sitemap'))
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('sitemap') }}">{{ __('Sitemap') }}</a>
                </li>
            @endif
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container-fluid">
        <h1>Sitemap</h1>
        <div class="row justify-content-center">

            @foreach ($sitemaps as $sitemap_package => $sitemap_blade)
                @includeWhen(!empty($sitemap_blade['view']), $sitemap_blade['view'])
            @endforeach

        </div>
    </div>
@endsection
