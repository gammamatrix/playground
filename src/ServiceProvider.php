<?php
/**
 * Playground
 */
namespace Playground;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

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

            if ($this->app->runningInConsole()) {
                // Publish configuration
                $this->publishes([
                    dirname(__DIR__).'/config/playground.php' => config_path('playground.php'),
                ], 'playground-config');
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

            '<fg=cyan;options=bold>User Model</> [auth.providers.users.model]' => sprintf('[%s]', config('auth.providers.users.model')),
            '<fg=cyan;options=bold>User Model</> [playground.user]' => sprintf('[%s]', $config['user']),
            '<fg=cyan;options=bold>User Model ID Type</>' => $config['user_id'],
            '<fg=cyan;options=bold>User Model Table</>' => $config['user_table'],

            'Packages' => empty($config['packages']) ? '' : implode(', ', $config['packages']),
            'Package' => $this->package,
            'Version' => $version,
        ]);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            sprintf('%1$s/config/%2$s.php', dirname(__DIR__), $this->package),
            $this->package
        );
    }

    public function version(): string
    {
        return static::VERSION;
    }
}
