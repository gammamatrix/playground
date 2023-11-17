<?php
/**
 * Site Layout
 *
 *
 * This is the main application template layout.
 *
 * resources/views/layouts/site/layout.blade.php
 *
 */

$package_config = config('playground');

// /**
//  * @var boolean $withNav Show the navigation in the layout.
//  */
// $withNav = isset($withNav) && is_bool($withNav) ? $withNav : true;

/**
 * @var boolean $withSidebarLeft Enable the left sidebar in the layout.
 */
$withSidebarLeft = isset($withSidebarLeft) && is_bool($withSidebarLeft) ? $withSidebarLeft : true;

/**
 * @var boolean $withSidebarRight Enable the right sidebar in the layout.
 */
$withSidebarRight = isset($withSidebarRight) && is_bool($withSidebarRight) ? $withSidebarRight : true;

/**
 * @var boolean $withFooter Show the footer in the layout.
 */
$withFooter = isset($withFooter) && is_bool($withFooter) ? $withFooter : true;
?>
@extends('playground::layouts.bootstrap', [
    // 'withNav' => $withNav,
    // 'withNav' => false,
    'withSidebarLeft' => $withSidebarLeft,
    'withSidebarRight' => $withSidebarRight,
    'withFooter' => $withFooter,
    // 'withBreadcrumbs' => true,
    // 'withSidebarLeft' => !Auth::check(),
])
