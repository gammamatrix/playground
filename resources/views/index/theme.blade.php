@extends($package_config['layout'])
@section('title', __('Theme'))
@section('breadcrumbs')
<nav aria-label="breadcrumb" class="m-3">
    <ol class="breadcrumb">
        @if (Route::has('home'))
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
        @endif
        @if (Route::has('theme'))
        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('theme') }}">{{ __('Theme') }}</a></li>
        @endif
    </ol>
</nav>
@endsection
