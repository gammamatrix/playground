@extends($package_config['layout'])
@section('title', __('Dashboard'))
@section('breadcrumbs')
    <nav aria-label="breadcrumb" class="m-3">
        <ol class="breadcrumb">
            @if (Route::has('home'))
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">{{ __('Home') }}</a>
                </li>
            @endif
            @if (Route::has('dashboard'))
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                </li>
            @endif
        </ol>
    </nav>
@endsection
