<div class="container alerts-container">
    <div class="row justify-content-center" id="alerts">
        @foreach (['danger', 'warning', 'success', 'info', 'primary', 'secondary', 'tertiary', 'quaternary', 'light', 'dark'] as $key)
            @if (Session::has($key))
                <div class="alert alert-{{ $key }} col mt-3 alert-block alert-dismissible fade show">
                    <strong>{{ Session::get($key) }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        @endforeach
    </div>
</div>
