<?php
/**
 * Playground
 */
namespace Playground\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
// use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * \Playground\Http\Controllers\Controller
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;
    // use DispatchesJobs;
}
