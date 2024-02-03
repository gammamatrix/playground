<?php
/**
 * Playground
 */
namespace Playground;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\Blade;

/**
 * \Playground\ServiceProvider
 */
class ServiceProvider extends AuthServiceProvider
{
    protected $package = 'playground';

    public const VERSION = '73.0.0';

    public function boot()
    {
        $config = config($this->package);

        if (! empty($config)) {
            $this->loadTranslationsFrom(
                dirname(__DIR__).'/lang',
                'playground'
            );

            $this->loadViewsFrom(
                dirname(__DIR__).'/resources/views',
                'playground'
            );

            $this->loadRoutesFrom(dirname(__DIR__).'/routes/playground.php');

            Blade::componentNamespace('Playground\\View\\Components', 'playground');

            if ($this->app->runningInConsole()) {
                // Publish configuration
                $this->publishes([
                    dirname(__DIR__).'/config/playground.php' => config_path('playground.php'),
                ], 'playground-config');

                // Publish JavaScript assets
                $this->publishes([
                    dirname(__DIR__).'/resources/js/playground.js' => public_path('vendor/playground.js'),
                ], 'playground-js');
            }

            $this->about();
        }
    }

    public function about()
    {
        $config = config($this->package);

        $version = $this->version();

        AboutCommand::add('Playground', fn () => [
            '<fg=yellow;options=bold>Load</> Routes' => ! empty($config['load']['routes']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=yellow;options=bold>Load</> Views' => ! empty($config['load']['views']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',

            '<fg=blue;options=bold>View</> [layout]' => sprintf('[%s]', $config['layout']),
            '<fg=blue;options=bold>View</> [prefix]' => sprintf('[%s]', $config['view']),

            '<fg=blue;options=bold>Purifier</> [path]' => sprintf('[%s]', empty($config['purifier']['path']) ? 'null' : $config['purifier']['path']),
            '<fg=blue;options=bold>Purifier</> [iframes]' => sprintf('[%s]', $config['purifier']['iframes']),

            '<fg=magenta;options=bold>Dashboard</> Views' => ! empty($config['dashboard']['enable']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=magenta;options=bold>Dashboard</> Guest' => ! empty($config['dashboard']['guest']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=magenta;options=bold>Dashboard</> User' => ! empty($config['dashboard']['user']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=magenta;options=bold>Dashboard</> [view]' => sprintf('[%s]', $config['dashboard']['view']),

            '<fg=magenta;options=bold>Sitemap</> Views' => ! empty($config['sitemap']['enable']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=magenta;options=bold>Sitemap</> Guest' => ! empty($config['sitemap']['guest']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=magenta;options=bold>Sitemap</> User' => ! empty($config['sitemap']['user']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=magenta;options=bold>Sitemap</> [view]' => sprintf('[%s]', $config['sitemap']['view']),

            '<fg=cyan;options=bold>User Model</> [auth.providers.users.model]' => sprintf('[%s]', config('auth.providers.users.model')),
            '<fg=cyan;options=bold>User Model</> [playground.user]' => sprintf('[%s]', $config['user']),
            '<fg=cyan;options=bold>User Model ID Type</>' => $config['user_id'],
            '<fg=cyan;options=bold>User Model Table</>' => $config['user_table'],

            '<fg=red;options=bold>Route</> about' => ! empty($config['routes']['about']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> bootstrap' => ! empty($config['routes']['bootstrap']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> dashboard' => ! empty($config['routes']['dashboard']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> home' => ! empty($config['routes']['home']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> sitemap' => ! empty($config['routes']['sitemap']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> theme' => ! empty($config['routes']['theme']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> welcome' => ! empty($config['routes']['welcome']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',

            'Packages' => empty($config['packages']) ? '' : implode(', ', $config['packages']),
            'Package' => $this->package,
            'Version' => $version,
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/config/playground.php',
            'playground'
        );
    }

    public function version()
    {
        return static::VERSION;
    }
}
