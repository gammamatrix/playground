<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Facades\Blade;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

/**
 * \GammaMatrix\Playground\ServiceProvider
 *
 */
class ServiceProvider extends AuthServiceProvider
{
    protected $package = 'playground';

    public const VERSION = '73.0.0';

    public function boot()
    {
        $config = config($this->package);

        if (!empty($config)) {
            $this->loadTranslationsFrom(
                dirname(__DIR__) . '/lang',
                'playground'
            );

            $this->loadViewsFrom(
                dirname(__DIR__) . '/resources/views',
                'playground'
            );

            $this->loadRoutesFrom(dirname(__DIR__) . '/routes/playground.php');

            Blade::componentNamespace('GammaMatrix\\Playground\\View\\Components', 'playground');

            if ($this->app->runningInConsole()) {
                // Publish configuration
                $this->publishes([
                    dirname(__DIR__).'/config/playground-matrix.php'
                        => config_path('playground-matrix.php')
                ], 'playground-config');

                // Publish JavaScript assets
                $this->publishes([
                    dirname(__DIR__).'/resources/js/playground.js' => public_path('vendor/playground.js'),
                ], 'public');
            }

            $this->about();
        }
    }

    public function about()
    {
        $config = config($this->package);

        $version = $this->version();

        AboutCommand::add('Playground', fn () => [
            '<fg=yellow;options=bold>Load</> Commands' => !empty($config['load']['commands']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=yellow;options=bold>Load</> Routes' => !empty($config['load']['routes']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=yellow;options=bold>Load</> Views' => !empty($config['load']['views']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',

            '<fg=blue;options=bold>View</> CDN' => !empty($config['cdn']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=blue;options=bold>View</> Layout' => $config['layout'],
            '<fg=blue;options=bold>View</> [prefix]' => sprintf('[%s]', $config['view']),

            '<fg=magenta;options=bold>Sitemap</> Views' => !empty($config['sitemap']['enable']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=magenta;options=bold>Sitemap</> Guest' => !empty($config['sitemap']['guest']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=magenta;options=bold>Sitemap</> User' => !empty($config['sitemap']['user']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=magenta;options=bold>Sitemap</> [view]' => sprintf('[%s]', $config['sitemap']['view']),

            'Packages' => empty($config['packages']) ? '' : implode(', ', $config['packages']),
            'Package' => $this->package,
            'Version' => $version,
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/config/playground.php',
            'playground'
        );
    }

    public function version()
    {
        return static::VERSION;
    }
}
