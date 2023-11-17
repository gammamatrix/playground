<footer class="mt-auto py-3">
    <nav class="nav nav-pills flex-column flex-sm-row">
        <span class="flex-sm-fill text-center navbar-text">
            {{config('app.name')}}
        </span>
        <span class="flex-sm-fill text-center navbar-text">
            <a href="/sitemap">Sitemap</a>
        </span>
        @auth
        {{-- <span class="flex-sm-fill text-center navbar-text">
            <a class="dropdown-item" href="{{ route('sitemap') }}">
                Sitemap
            </a>
        </span> --}}
        @endauth
    </nav>
<!-- @stack('snippet-footer') {{-- snippet-main rank === 200 --}} -->
</footer>
