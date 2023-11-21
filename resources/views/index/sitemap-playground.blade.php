<div class="card my-1">
    <div class="card-body">

        <div class="row">

            <div class="col-sm-6 mb-3">
                <div class="card">
                    <div class="card-header">
                        {{ __('Guests and Users') }}
                        <small class="text-muted">{{ __('site access') }}</small>
                    </div>
                    <ul class="list-group list-group-flush">

                        @if (Route::has('about'))
                            <a href="{{ route('about') }}" class="list-group-item list-group-item-action">
                                {{ __('About') }}
                            </a>
                        @endif

                        @if (Route::has('dashboard'))
                            <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action">
                                {{ __('Dashboard') }}
                            </a>
                        @endif

                        @if (Route::has('home'))
                            <a href="{{ route('home') }}" class="list-group-item list-group-item-action">
                                {{ __('Home') }}
                            </a>
                        @endif

                        @if (Route::has('welcome'))
                            <a href="{{ route('welcome') }}" class="list-group-item list-group-item-action">
                                {{ __('Welcome') }}
                            </a>
                        @endif

                    </ul>
                </div>
            </div>

            @if (Route::has('bootstrap') || Route::has('theme'))
            <div class="col-sm-6 mb-3">
                <div class="card">
                    <div class="card-header">
                        {{ __('Themes') }}
                        <small class="text-muted">{{ __('dark mode, theme previews and switching themes') }}</small>
                    </div>
                    <ul class="list-group list-group-flush">

                        @if (Route::has('bootstrap'))
                            <a href="{{ route('bootstrap') }}" class="list-group-item list-group-item-action">
                                {{ __('Bootstrap Components') }}
                            </a>
                        @endif

                        @if (Route::has('theme') && is_array(config('playground.themes')))
                        @foreach (config('playground.themes') as $theme)
                        @continue(empty($theme['enable']) || empty($theme['label']))

                        <a class="list-group-item list-group-item-action" href="{{ route('theme', ['appTheme' => ($theme['key'] ?? ''), '_return_url' => request()->url()])}}">
                            @if (!empty($theme['icon']) && is_string($theme['icon']))<i class="{{$theme['icon']}}"></i>@endif
                            {{$theme['label']}}
                        </a>

                        @endforeach
                        @endif

                    </ul>
                </div>
            </div>
            @endif

        </div>

    </div>
</div>
