<div class="card my-1">
    <div class="card-body">

        <h2>Site</h2>

        <div class="row">

            <div class="col-sm-6 mb-3">
                <div class="card">
                    <div class="card-header">
                    Guests and Users
                    <small class="text-muted">client access</small>
                    </div>
                    <ul class="list-group list-group-flush">
                        {{-- <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action">
                            Dashboard
                        </a> --}}
                        <a href="{{ route('home') }}" class="list-group-item list-group-item-action">
                            Home
                        </a>
                        <a href="{{ route('login') }}" class="list-group-item list-group-item-action">
                            Login
                        </a>
                        <a href="{{ route('logout') }}" class="list-group-item list-group-item-action">
                            Logout
                        </a>
                    </ul>
                </div>
            </div>

        </div>

    </div>
</div>
