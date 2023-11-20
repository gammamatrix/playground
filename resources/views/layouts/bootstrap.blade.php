<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<?php

$package_config = config('playground');

/**
 * @var string $appName The application name.
 */
$appName = isset($appName)
    && is_string($appName)
    && !empty($appName)
    ? $appName
    : config('app.name')
;

/**
 * @var string $appTheme The application theme.
 */
$appTheme = isset($appTheme)
    && is_string($appTheme)
    && !empty($appTheme)
    ? $appTheme
    : session('appTheme')
;

/**
 * @var boolean $withAlerts Show the alerts in the layout.
 */
$withAlerts = isset($withAlerts) && is_bool($withAlerts) ? $withAlerts : true;

/**
 * @var array $fonts The display font.
 */
$fonts = [
    'nunito' => [
        'href' => 'https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap',
        'rel' => 'stylesheet',
    ],
];

/**
 * @var boolean $withErrors Show the errors in the layout.
 */
$withErrors = isset($withErrors) && is_bool($withErrors) ? $withErrors : true;

/**
 * @var boolean $withBreadcrumbs Show the breadcrumbs in the layout.
 */
$withBreadcrumbs = isset($withBreadcrumbs) && is_bool($withBreadcrumbs) ? $withBreadcrumbs : true;

/**
 * @var string $withBodyClass The class to put in the body tag.
 */
$withBodyClass = isset($withBodyClass) && is_string($withBodyClass) ? $withBodyClass : 'd-flex flex-column min-vh-100';

/**
 * @var string $withMainClass The class to put in the main tag.
 */
$withMainClass = isset($withMainClass) && is_string($withMainClass) ? $withMainClass : 'flex-shrink-0';

/**
 * @var boolean $withEditor Load the editor for forms.
 */
$withEditor = isset($withEditor) && is_bool($withEditor) ? $withEditor : false;

/**
 * @var boolean $withFooter Show the footer in the layout.
 */
$withFooter = isset($withFooter) && (is_bool($withFooter) || is_string($withFooter)) ? $withFooter : false;

/**
 * @var boolean $withUserMenu Display the user menu in the nav bar.
 */
$withUserMenu = isset($withUserMenu) && is_bool($withUserMenu) ? $withUserMenu : true;

/**
 * @var boolean|string $withNav Show the navigation in the layout.
 */
$withNav = isset($withNav) && (is_bool($withNav) || is_string($withNav)) ? $withNav : true;

/**
 * @var boolean $withSidebarLeft Enable the left sidebar in the layout.
 */
$withSidebarLeft = isset($withSidebarLeft) && (is_bool($withSidebarLeft) || is_string($withSidebarLeft)) ? $withSidebarLeft : false;

/**
 * @var boolean $withSidebarRight Enable the right sidebar in the layout.
 */
$withSidebarRight = isset($withSidebarRight) && (is_bool($withSidebarRight) || is_string($withSidebarRight)) ? $withSidebarRight : false;

/**
 * @var boolean $withScripts Enable the script assets.
 */
$withScripts = isset($withScripts) && is_bool($withScripts) ? $withScripts : true;

/**
 * @var boolean $withSnippets Show the snippets in the layout.
 */
$withSnippets = isset($withSnippets) && is_bool($withSnippets) ? $withSnippets : false;

/**
 * @var boolean $withIcons Enable the script assets.
 */
$withIcons = isset($withIcons) && is_bool($withIcons) ? $withIcons : true;

/**
 * @var boolean $withVue Enable Vue JS
 */
$withVue = isset($withVue) && is_bool($withVue) ? $withVue : true;

$withMix = isset($withMix) && is_bool($withMix) ? $withMix : false;

$withPlayground = isset($withPlayground) && is_bool($withPlayground) ? $withPlayground : true;
// $withPlayground = false;
/**
 * @var array The view library asset information.
 */
$libs = config(sprintf('playground.libs.%1$s', config('playground.cdn', true) ? 'cdn' : 'vendor'));
// dd([
//     '__METHOD__' => __METHOD__,
//     '__FILE__' => __FILE__,
//     '__LINE__' => __LINE__,
//     '$libs' => $libs,
//     'config' => config('playground'),
//     'playground.cdn' => config('playground.cdn'),
// ]);

/**
 * @var array The order matters for the rendering of scripts.
 */
$scriptList = [];

if ($withScripts) {
    $scriptList[] = 'moment';

    if ($withEditor) {
        $scriptList[] = 'ckeditor';
    }

    if ($withPlayground) {
        $scriptList[] = 'playground';
    }

    $scriptList[] = 'jquery';
    $scriptList[] = 'popper';

    if ($withIcons) {
        $scriptList[] = 'fontawesome';
    }
}
?>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/favicon.ico">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ !empty($appName) ? sprintf('%1$s: ', $appName) : '' }}@yield('title')</title>

    <!-- Fonts -->
    @foreach ($fonts as $fontSlug => $fontMeta)
    @if (!empty($fontMeta['href']))
<link href="{{$fontMeta['href']}}" @if (!empty($fontMeta['rel']))rel="{{$fontMeta['rel']}}" @endif>
    @endif
    @endforeach

    <!-- Bootstrap CSS -->
    {{-- https://github.com/vinorodrigues/bootstrap-dark-5 --}}
    @if ('bootstrap-dark' === $appTheme)
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-dark-5@1.1.3/dist/css/bootstrap-dark.min.css" rel="stylesheet" crossorigin="anonymous">
    @else
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- @if ($withIcons && !empty($libs['fontawesome-css']) && !empty($libs['fontawesome-css']['url']))
        <link rel="stylesheet" href="{{$libs['fontawesome-css']['url']}}" @if (!empty($libs['fontawesome-css']['integrity']))integrity="{{$libs['fontawesome-css']['integrity']}}"@endif crossorigin="anonymous">
    @endif --}}

    @if ($withVue)
    <script src="https://unpkg.com/vue@3"></script>
    @endif

    @foreach ($scriptList as $script)
    @continue(empty($libs[$script]) || empty($libs[$script]['url']))
        <?= sprintf('<script src="%1$s"%2$s%3$s></script>',
        $libs[$script]['url'],
        empty($libs[$script]['integrity']) ? '' : sprintf(' integrity="%1$s"', $libs[$script]['integrity']),
        empty($libs[$script]['crossorigin']) ? '' : sprintf(' crossorigin="%1$s"', $libs[$script]['crossorigin'])
        ) ?>

    @endforeach

    @stack('scripts')
    @yield('head')

    @if (!$withBreadcrumbs)
    <style>
    .breadcrumb {
        display: none;
    }
    </style>
    @endif
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
        .ck-editor__editable_inline, .editor__editable {
            min-height: 200px;
        }
    </style>
</head>

<body class="{{$withBodyClass}}">

@yield('pre-header')

@yield('header')

@yield('pre-nav')

@if (is_bool($withNav))
@include(sprintf('%1$slayouts/bootstrap/nav', $package_config['view']))
@elseif (!empty($withNav) && is_string($withNav))
@include($withNav)
@endif

@if (is_bool($withSidebarLeft))
@include(sprintf('%1$slayouts/bootstrap/sidebar-left', $package_config['view']))
@elseif (!empty($withSidebarLeft) && is_string($withSidebarLeft))
@include($withSidebarLeft)
@endif

@if (is_bool($withSidebarRight))
@include(sprintf('%1$slayouts/bootstrap/sidebar-right', $package_config['view']))
@elseif (!empty($withSidebarRight) && is_string($withSidebarRight))
@include($withSidebarRight)
@endif

@yield('pre-main')

<main role="main" class="{{$withMainClass}}">
@yield('breadcrumbs')
@includeWhen($withAlerts, sprintf('%1$slayouts/bootstrap/alerts', $package_config['view']))
@includeWhen($withErrors, sprintf('%1$slayouts/bootstrap/errors', $package_config['view']))
@yield('main')
@yield('content')
@yield('content-end')
</main>

@yield('pre-footer')

@if (is_bool($withFooter))
@include(sprintf('%1$slayouts/bootstrap/footer', $package_config['view']))
@elseif (!empty($withFooter) && is_string($withFooter))
@include($withFooter)
@endif

@yield('body')
@stack('body-first')
@stack('body')
@stack('modals')
@stack('body-last')

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/js/all.min.js" integrity="sha512-8pHNiqTlsrRjVD4A/3va++W1sMbUHwWxxRPWNyVlql3T+Hgfd81Qc6FC5WMXDC+tSauxxzp1tgiAvSKFu1qIlA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@if ($withMix)
<script src="{{ mix('/js/app.js') }}"></script>
@endif

</body>

</html>
