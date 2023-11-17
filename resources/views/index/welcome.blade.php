@extends($package_config['layout'])
@section('title', 'Welcome')
@section('breadcrumbs')
<nav aria-label="breadcrumb" class="m-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('welcome') }}">Welcome</a></li>
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
