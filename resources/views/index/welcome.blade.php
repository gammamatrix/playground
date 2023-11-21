@extends($package_config['layout'])
@section('title', __('Welcome'))
@section('breadcrumbs')
<nav aria-label="breadcrumb" class="m-3">
    <ol class="breadcrumb">
        @if (Route::has('home'))
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
        @endif
        @if (Route::has('welcome'))
        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('welcome') }}">{{ __('Welcome') }}</a></li>
        @endif
    </ol>
</nav>
@endsection
@section('content')
<div class="container-fluid">
    <h1>Welcome</h1>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card my-1">
                <div class="card-body">

                    <h2>--</h2>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
