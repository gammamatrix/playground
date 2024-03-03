<?php
/**
 * Playground
 */
namespace Playground\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * \Playground\Models\User
 */
class User extends Authenticatable implements Contracts\Abilities, Contracts\Admin, Contracts\Privileges, Contracts\Role, MustVerifyEmail
{
    use HasFactory, Notifiable;
    use HasUuids;
    use SoftDeletes;
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
        'created_by_id' => null,
        'modified_by_id' => null,
        'user_type' => null,
        'created_at' => null,
        'updated_at' => null,
        'deleted_at' => null,
        'banned_at' => null,
        'suspended_at' => null,
        'gids' => 0,
        'po' => 0,
        'pg' => 0,
        'pw' => 0,
        'status' => 0,
        'rank' => 0,
        'size' => 0,
        'active' => true,
        'banned' => false,
        'flagged' => false,
        'internal' => false,
        'locked' => false,
        'problem' => false,
        'suspended' => false,
        'unknown' => false,
        'name' => '',
        'email' => '',
        'password' => '',
        'phone' => null,
        'locale' => '',
        'timezone' => '',
        'label' => '',
        'title' => '',
        'byline' => '',
        'slug' => null,
        'url' => '',
        'description' => '',
        'introduction' => '',
        'content' => null,
        'summary' => null,
        'icon' => '',
        'image' => '',
        'avatar' => '',
        // JSON
        'ui' => '{}',
        // Abilities are shared with SPAs
        'abilities' => '[]',
        'accounts' => '{}',
        'address' => '{}',
        'contact' => '{}',
        'meta' => '{}',
        'notes' => '[]',
        'options' => '{}',
        'registration' => '{}',
        'roles' => '[]',
        'permissions' => '[]',
        'privileges' => '[]',
        'sources' => '[]',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_type',
        'resolved_at',
        'suspended_at',
        'gids',
        'po',
        'pg',
        'pw',
        'status',
        'rank',
        'size',
        'active',
        'banned',
        'flagged',
        'internal',
        'locked',
        'problem',
        'suspended',
        'unknown',
        'name',
        'email',
        'address',
        'password',
        'phone',
        'locale',
        'timezone',
        'label',
        'title',
        'byline',
        'slug',
        'url',
        'description',
        'introduction',
        'content',
        'summary',
        'icon',
        'image',
        'avatar',
        'ui',
        'assets',
        'meta',
        'options',
        'sources',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'banned_at',
        'suspended_at',
        'password',
        'remember_token',
        'banned',
        'flagged',
        'internal',
        'problem',
        'suspended',
        'unknown',
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
        'sources',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'banned_at' => 'datetime',
        'suspended_at' => 'datetime',
        'gids' => 'integer',
        'po' => 'integer',
        'pg' => 'integer',
        'pw' => 'integer',
        'status' => 'integer',
        'rank' => 'integer',
        'size' => 'integer',
        // Boolean
        'active' => 'boolean',
        'banned' => 'boolean',
        'flagged' => 'boolean',
        'internal' => 'boolean',
        'locked' => 'boolean',
        'problem' => 'boolean',
        'suspended' => 'boolean',
        'unknown' => 'boolean',
        // 'id' => 'uuid',
        'name' => 'string',
        'email' => 'string',
        'locale' => 'string',
        'phone' => 'encrypted',
        'timezone' => 'string',
        'role' => 'string',
        'description' => 'string',
        'image' => 'string',
        'avatar' => 'string',
        // json
        'abilities' => 'array',
        'accounts' => 'encrypted:array',
        'address' => 'encrypted:array',
        'contact' => 'encrypted:array',
        'meta' => 'encrypted:array',
        'notes' => 'encrypted:array',
        'options' => 'encrypted:array',
        'registration' => 'encrypted:array',
        'roles' => 'array',
        'permissions' => 'array',
        'privileges' => 'array',
        'ui' => 'array',
    ];

    /**
     * Disable auto-incrementing primary when using a UUID column.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $perPage = 250;
}
