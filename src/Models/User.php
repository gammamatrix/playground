<?php
/**
 * Playground
 */
namespace Playground\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * \Playground\Models\User
 */
class User extends Authenticatable implements Contracts\Abilities, Contracts\Admin, Contracts\Privileges, Contracts\Role, MustVerifyEmail
{
    use HasFactory, Notifiable;
    use HasUuids;
    use Traits\Abilities;
    use Traits\Admin;
    use Traits\Privileges;
    use Traits\Role;

    /**
     * The default values for attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        // JSON
        // Abilities are shared with SPAs
        'abilities' => '{}',
        'accounts' => '{}',
        'address' => '{}',
        'meta' => '{}',
        'notes' => '[]',
        'options' => '{}',
        'registration' => '[]',
        'roles' => '[]',
        'permissions' => '[]',
        'privileges' => '[]',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'address',
        'password',
        'phone',
        'locale',
        'timezone',
        'description',
        'style',
        'klass',
        'icon',
        'image',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'accounts',
        'address',
        'contact',
        'meta',
        'notes',
        'options',
        'registration',
        'roles',
        'permissions',
        'privileges',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
        // 'id' => 'uuid',
        'name' => 'string',
        'email' => 'string',
        'locale' => 'string',
        'phone' => 'string',
        'timezone' => 'string',
        'role' => 'string',
        'description' => 'string',
        'image' => 'string',
        'avatar' => 'string',
        // Boolean
        'active' => 'boolean',
        'banned' => 'boolean',
        'closed' => 'boolean',
        'flagged' => 'boolean',
        'internal' => 'boolean',
        'locked' => 'boolean',
        // dates
        'email_verified_at' => 'datetime',
        // 'deleted_at' => 'datetime',
        // json
        'abilities' => 'array',
        'accounts' => 'array',
        'address' => 'array',
        'contact' => 'array',
        'meta' => 'array',
        'notes' => 'array',
        'options' => 'array',
        'registration' => 'array',
        'roles' => 'array',
        'permissions' => 'array',
        'privileges' => 'array',
    ];

    /**
     * Disable auto-incrementing primary when using a UUID column.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $perPage = 250;
}
