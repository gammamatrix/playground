<?php

declare(strict_types=1);
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

            '<fg=cyan;options=bold>User</> Illuminate\Database\Eloquent\Factories\HasFactory' => $this->userHasFactory ? '<fg=green;options=bold>USED</>' : '<fg=yellow;options=bold>NOT USED</>',
            '<fg=cyan;options=bold>User</> Illuminate\Database\Eloquent\Model' => $this->userIsEloquentModel ? '<fg=green;options=bold>EXTENDED</>' : '<fg=yellow;options=bold>NOT EXTENDED</>',
            '<fg=cyan;options=bold>User</> Illuminate\Database\Eloquent\Concerns\HasUuids' => $this->userHasEloquentUuids ? '<fg=green;options=bold>USED</>' : '<fg=yellow;options=bold>NOT USED</>',
            '<fg=cyan;options=bold>User</> Illuminate\Notifications\Notifiable' => $this->userHasNotifiable ? '<fg=green;options=bold>USED</>' : '<fg=yellow;options=bold>NOT USED</>',
            '<fg=cyan;options=bold>User</> Illuminate\Contracts\Auth\MustVerifyEmail' => $this->userHasMustVerifyEmail ? '<fg=green;options=bold>IMPLEMENTED</>' : '<fg=yellow;options=bold>NOT IMPLEMENTED</>',

            '<fg=cyan;options=bold>User</> Illuminate\Auth\Passwords\CanResetPassword' => $this->userCanResetPasswordConcern ? '<fg=green;options=bold>USED</>' : '<fg=yellow;options=bold>NOT USED</>',
            '<fg=cyan;options=bold>User</> Illuminate\Contracts\Auth\CanResetPassword' => $this->userCanResetPasswordContract ? '<fg=green;options=bold>IMPLEMENTED</>' : '<fg=yellow;options=bold>NOT IMPLEMENTED</>',

            '<fg=cyan;options=bold>User</> Illuminate\Foundation\Auth\Access\Authorizable' => $this->userHasAuthorizableConcerns ? '<fg=green;options=bold>USED</>' : '<fg=yellow;options=bold>NOT USED</>',
            '<fg=cyan;options=bold>User</> Illuminate\Contracts\Auth\Access\Authorizable' => $this->userHasAuthorizableContracts ? '<fg=green;options=bold>IMPLEMENTED</>' : '<fg=yellow;options=bold>NOT IMPLEMENTED</>',

            '<fg=cyan;options=bold>User</> Illuminate\Auth\Authenticatable' => $this->userHasAuthenticatableConcerns ? '<fg=green;options=bold>USED</>' : '<fg=yellow;options=bold>NOT USED</>',
            '<fg=cyan;options=bold>User</> Illuminate\Contracts\Auth\Authenticatable' => $this->userHasAuthenticatableContracts ? '<fg=green;options=bold>IMPLEMENTED</>' : '<fg=yellow;options=bold>NOT IMPLEMENTED</>',

            '<fg=cyan;options=bold>User</> Playground\Models\Concerns\Abilities' => $this->userPlaygroundAbilitiesConcerns ? '<fg=green;options=bold>USED</>' : '<fg=yellow;options=bold>NOT USED</>',
            '<fg=cyan;options=bold>User</> Playground\Models\Contracts\Abilities' => $this->userHasPlaygroundAbilitiesContracts ? '<fg=green;options=bold>IMPLEMENTED</>' : '<fg=yellow;options=bold>NOT IMPLEMENTED</>',

            '<fg=cyan;options=bold>User</> Playground\Models\Concerns\Admin' => $this->userPlaygroundAdminConcerns ? '<fg=green;options=bold>USED</>' : '<fg=yellow;options=bold>NOT USED</>',
            '<fg=cyan;options=bold>User</> Playground\Models\Contracts\Admin' => $this->userHasPlaygroundAdminContracts ? '<fg=green;options=bold>IMPLEMENTED</>' : '<fg=yellow;options=bold>NOT IMPLEMENTED</>',

            '<fg=cyan;options=bold>User</> Playground\Models\Concerns\Privileges' => $this->userPlaygroundPrivilegesConcerns ? '<fg=green;options=bold>USED</>' : '<fg=yellow;options=bold>NOT USED</>',
            '<fg=cyan;options=bold>User</> Playground\Models\Contracts\Privileges' => $this->userHasPlaygroundPrivilegesContracts ? '<fg=green;options=bold>IMPLEMENTED</>' : '<fg=yellow;options=bold>NOT IMPLEMENTED</>',

            '<fg=cyan;options=bold>User</> Playground\Models\Concerns\Role' => $this->userPlaygroundRoleConcerns ? '<fg=green;options=bold>USED</>' : '<fg=yellow;options=bold>NOT USED</>',
            '<fg=cyan;options=bold>User</> Playground\Models\Contracts\Role' => $this->userHasPlaygroundRoleContracts ? '<fg=green;options=bold>IMPLEMENTED</>' : '<fg=yellow;options=bold>NOT IMPLEMENTED</>',

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

    protected bool $userHasFactory;

    protected bool $userCanResetPasswordConcern;

    protected bool $userCanResetPasswordContract;

    protected bool $userHasAuthorizableConcerns;

    protected bool $userHasAuthorizableContracts;

    protected bool $userIsEloquentModel;

    protected bool $userHasEloquentUuids;

    protected bool $userHasNotifiable;

    protected bool $userHasAuthenticatableConcerns;

    protected bool $userHasAuthenticatableContracts;

    protected bool $userHasMustVerifyEmail;

    protected bool $userPlaygroundAbilitiesConcerns;

    protected bool $userHasPlaygroundAbilitiesContracts;

    protected bool $userPlaygroundAdminConcerns;

    protected bool $userHasPlaygroundAdminContracts;

    protected bool $userPlaygroundPrivilegesConcerns;

    protected bool $userHasPlaygroundPrivilegesContracts;

    protected bool $userPlaygroundRoleConcerns;

    protected bool $userHasPlaygroundRoleContracts;

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

        $this->userHasFactory = in_array(\Illuminate\Database\Eloquent\Factories\HasFactory::class, class_uses_recursive($user));

        $this->userCanResetPasswordConcern = in_array(\Illuminate\Auth\Passwords\CanResetPassword::class, class_uses_recursive($user));
        $this->userCanResetPasswordContract = $user instanceof \Illuminate\Contracts\Auth\CanResetPassword;

        $this->userHasAuthorizableConcerns = in_array(\Illuminate\Foundation\Auth\Access\Authorizable::class, class_uses_recursive($user));
        $this->userHasAuthorizableContracts = $user instanceof \Illuminate\Contracts\Auth\Access\Authorizable;

        $this->userIsEloquentModel = $user instanceof \Illuminate\Database\Eloquent\Model;

        $this->userHasEloquentUuids = in_array(\Illuminate\Database\Eloquent\Concerns\HasUuids::class, class_uses_recursive($user));
        $this->userHasNotifiable = in_array(\Illuminate\Notifications\Notifiable::class, class_uses_recursive($user));

        $this->userHasAuthenticatableConcerns = in_array(\Illuminate\Auth\Authenticatable::class, class_uses_recursive($user));
        $this->userHasAuthenticatableContracts = $user instanceof \Illuminate\Contracts\Auth\Authenticatable;

        $this->userHasMustVerifyEmail = $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail;

        $this->userPlaygroundAbilitiesConcerns = in_array(Models\Concerns\Abilities::class, class_uses_recursive($user));
        $this->userHasPlaygroundAbilitiesContracts = $user instanceof Models\Contracts\Abilities;

        $this->userPlaygroundAdminConcerns = in_array(Models\Concerns\Admin::class, class_uses_recursive($user));
        $this->userHasPlaygroundAdminContracts = $user instanceof Models\Contracts\Admin;

        $this->userPlaygroundPrivilegesConcerns = in_array(Models\Concerns\Privileges::class, class_uses_recursive($user));
        $this->userHasPlaygroundPrivilegesContracts = $user instanceof Models\Contracts\Privileges;

        $this->userPlaygroundRoleConcerns = in_array(Models\Concerns\Role::class, class_uses_recursive($user));
        $this->userHasPlaygroundRoleContracts = $user instanceof Models\Contracts\Role;

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
