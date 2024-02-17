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
            // $this->loadTranslationsFrom(
            //     dirname(__DIR__).'/lang',
            //     'playground'
            // );

            if ($this->app->runningInConsole()) {
                // Publish configuration
                $this->publishes([
                    sprintf('%1$s/config/%2$s.php', dirname(__DIR__), $this->package) => config_path(sprintf('%1$s.php', $this->package)),
                ], 'playground-config');
            }

        }

        $this->about($config);
    }

    /**
     * @param array<string, mixed> $config
     */
    public function about(array $config): void
    {
        $packages = ! empty($config['packages']) && is_array($config['packages']) ? $config['packages'] : [];

        $version = $this->version();

        /**
         * @var class-string $auth_providers_users_model
         */
        $auth_providers_users_model = config('auth.providers.users.model');

        AboutCommand::add('Playground', fn () => [
            '<fg=cyan;options=bold>User</> [auth.providers.users.model]' => sprintf('[%s]', is_string($auth_providers_users_model) ? $auth_providers_users_model : ''),
            '<fg=cyan;options=bold>User Primary</>' => $this->userPrimaryKeyType($auth_providers_users_model),

            'Packages' => implode(', ', $packages),
            'Package' => $this->package,
            'Version' => $version,
        ]);
    }

    /**
     * @param ?class-string $auth_providers_users_model
     */
    public function userPrimaryKeyType(string $auth_providers_users_model = null): string
    {
        try {
            if (! $auth_providers_users_model || ! class_exists($auth_providers_users_model)) {
                return '<fg=yellow;options=bold>invalid</>';
            }

            return $this->userPrimaryKeyTypeParse($auth_providers_users_model);
        } catch (\Throwable $th) {
            \Log::debug($th->__toString());

            return '<fg=red;options=bold>error</>';
        }
    }

    /**
     * @param class-string $auth_providers_users_model
     */
    private function userPrimaryKeyTypeParse(string $auth_providers_users_model): string
    {
        $model_info = '';
        /**
         * @var \Illuminate\Contracts\Auth\Authenticatable
         */
        $user = new $auth_providers_users_model;

        if (in_array(\Illuminate\Database\Eloquent\Concerns\HasUuids::class, class_uses_recursive($user))
            && ! $user->getIncrementing()
        ) {
            $model_info = '<fg=green;options=bold>UUID</>';
        } elseif ($user->getIncrementing()) {
            $model_info = '<fg=green;options=bold>increments</>';
        }

        return $model_info;
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
