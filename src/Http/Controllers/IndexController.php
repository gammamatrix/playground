<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

/**
 * \GammaMatrix\Playground\Http\Controllers\IndexController
 *
 * TODO: Add back in handling for CMS snippets.
 */
class IndexController extends Controller
{
    public function about(Request $request): JsonResponse|View
    {
        $payload = [
            'data' => [],
            'meta' => [
                'timestamp' => Carbon::now()->toJson(),
            ],
            'package_config' => config('playground'),
        ];

        if ($request->expectsJson()) {
            return response()->json($payload);
        }

        return view('playground::index.about', $payload);
    }

    public function bootstrap(Request $request): JsonResponse|View
    {
        $payload = [
            'data' => [],
            'meta' => [
                'timestamp' => Carbon::now()->toJson(),
            ],
            'package_config' => config('playground'),
        ];

        if ($request->expectsJson()) {
            return response()->json($payload);
        }

        return view('playground::index.bootstrap', $payload);
    }

    public function dashboard(Request $request): JsonResponse|RedirectResponse|View
    {
        $package_config = config('playground');
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     'package_config' => $package_config,
        // ]);

        // Is the dashboard enabled?
        if (empty($package_config['dashboard']) || empty($package_config['dashboard']['enable'])) {
            abort_if($request->has('noredirect'), 400);
            return redirect('/');
        }

        $user = $request->user();

        // Is the dashboard enabled for guests?
        if (empty($package_config['dashboard']['guest']) && empty($user)) {
            abort_if($request->has('noredirect'), 400);
            return redirect('/');
        }

        $payload = [
            'data' => [],
            'meta' => [
                'timestamp' => Carbon::now()->toJson(),
            ],
            'package_config' => $package_config,
        ];

        if ($request->expectsJson()) {
            return response()->json($payload);
        }

        return view('playground::index.dashboard', $payload);
    }

    public function home(Request $request): JsonResponse|RedirectResponse|View
    {
        $package_config = config('playground');

        $payload = [
            'data' => [],
            'meta' => [
                'timestamp' => Carbon::now()->toJson(),
            ],
            'package_config' => $package_config,
        ];

        if ($request->expectsJson()) {
            return response()->json($payload);
        }

        return view('playground::index.home', $payload);
    }

    public function sitemap(Request $request): JsonResponse|RedirectResponse|View
    {
        $package_config = config('playground');

        // Is the sitemap enabled?
        if (empty($package_config['sitemap']) || empty($package_config['sitemap']['enable'])) {
            abort_if($request->has('noredirect'), 400);
            return redirect('/');
        }

        $user = $request->user();

        // Is the sitemap enabled for guests?
        if (empty($package_config['sitemap']['guest']) && empty($user)) {
            abort_if($request->has('noredirect'), 400);
            return redirect('/');
        }

        $configs = [];
        foreach ($package_config['packages'] as $package) {
            if (is_string($package) && ! empty($package) && ! array_key_exists($package, $configs)) {
                $configs[$package] = config($package);
            }
        }

        $sitemaps = [];

        foreach ($configs as $package => $config) {
            if (! empty($config['sitemap'])
                && is_array($config['sitemap'])
                && ! empty($config['sitemap']['enable'])
                && is_array($config['load'])
                && ! empty($config['load']['views'])
            ) {
                $sitemaps[$package] = $config['sitemap'];
            }
        }
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '__FILE__' => __FILE__,
        //     '__LINE__' => __LINE__,
        //     '$configs' => $configs,
        //     '$sitemaps' => $sitemaps,
        // ]);

        return view('playground::index.sitemap', [
            'package_config' => $package_config,
            'configs' => $configs,
            'sitemaps' => $sitemaps,
            // 'snippets' => $this->snippetsForRoute($request),
        ]);
    }

    public function theme(Request $request): JsonResponse|RedirectResponse|View
    {
        $package_config = config('playground');

        $preview = $request->has('preview');
        $appTheme = (string) $request->input('appTheme');
        $_return_url = (string) $request->input('_return_url');

        if ($preview) {
            return view('playground::index.theme', [
                // 'snippets' => $this->snippetsForRoute($request),
                'package_config' => $package_config,
            ]);
        }

        if (!empty($appTheme)) {
            session(['appTheme' => $appTheme]);
        }
        $_return_url = empty($_return_url) ? '/' : $_return_url;
        return redirect($_return_url);
    }

    public function welcome(Request $request): JsonResponse|View
    {
        $payload = [
            'data' => [],
            'meta' => [
                'timestamp' => Carbon::now()->toJson(),
            ],
            'package_config' => config('playground'),
        ];

        if ($request->expectsJson()) {
            return response()->json($payload);
        }

        return view('playground::index.welcome', $payload);
    }
}
