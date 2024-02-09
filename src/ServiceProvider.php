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
    protected string $package = 'playground';

    public const VERSION = '73.0.0';

    public function boot(): void
    {
        /**
         * @var array<string, mixed> $config
         */
        $config = config($this->package);

        if (! empty($config['load']) && is_array($config['load'])) {
            $this->loadTranslationsFrom(
                dirname(__DIR__).'/lang',
                'playground'
            );

            if ($this->app->runningInConsole()) {
                // Publish configuration
                $this->publishes([
                    sprintf('%1$s/config/%2$s.php', dirname(__DIR__), $this->package) => config_path(sprintf('%1$s.php', $this->package)),
                ], 'playground-config');
            }

            $this->about($config);
        }
    }

    /**
     * @param array<string, mixed> $config
     */
    public function about(array $config): void
    {
        $purifier = ! empty($config['purifier']) && is_array($config['purifier']) ? $config['purifier'] : [];
        $packages = ! empty($config['packages']) && is_array($config['packages']) ? $config['packages'] : [];

        $version = $this->version();

        $auth_providers_users_model = config('auth.providers.users.model');

        AboutCommand::add('Playground', fn () => [
            '<fg=blue;options=bold>Purifier</> [path]' => sprintf('[%s]', empty($purifier['path']) ? 'null' : $purifier['path']),
            '<fg=blue;options=bold>Purifier</> [iframes]' => sprintf('[%s]', is_string($purifier['iframes']) ? $purifier['iframes'] : ''),

            '<fg=cyan;options=bold>User</> [auth.providers.users.model]' => sprintf('[%s]', is_string($auth_providers_users_model) ? $auth_providers_users_model : ''),
            '<fg=cyan;options=bold>User</> [playground.user]' => sprintf('[%s]', is_string($config['user']) ? $config['user'] : ''),

            '<fg=cyan;options=bold>User Model ID Type</>' => $config['user_id'],
            '<fg=cyan;options=bold>User Model Table</>' => $config['user_table'],

            'Packages' => implode(', ', $packages),
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
