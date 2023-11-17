<?php
/**
 * API Layout: index
 *
 *
 * resources/views/layouts/api/index.blade.php
 *
 */

$package_config = config('playground');


?>
@extends($package_config['layout'])
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">

@yield('section-primary')

@yield('section-secondary')

    </div>
</div>
@endsection
