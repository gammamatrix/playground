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
use Illuminate\Support\Carbon;
use Laravel\Sanctum;

/**
 * \Playground\Models\User
 *
 * @property string $id
 * @property string $created_by_id
 * @property string $modified_by_id
 * @property string $user_type
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property ?Carbon $email_verified_at
 * @property ?Carbon $banned_at
 * @property ?Carbon $suspended_at
 * @property int $gids
 * @property int $po
 * @property int $pg
 * @property int $pw
 * @property int $status
 * @property int $rank
 * @property int $size
 * @property string $matrix
 * @property ?double $r
 * @property ?double $θ
 * @property ?double $ρ
 * @property ?double $φ
 * @property ?double $elevation
 * @property ?double $latitude
 * @property ?double $longitude
 * @property ?int $x
 * @property ?int $y
 * @property ?int $z
 * @property bool $active
 * @property bool $banned
 * @property bool $flagged
 * @property bool $internal
 * @property bool $locked
 * @property bool $problem
 * @property bool $suspended
 * @property bool $unknown
 * @property string $name
 * @property string $email
 * @property string $locale
 * @property string $phone
 * @property string $timezone
 * @property string $role
 * @property string $description
 * @property string $image
 * @property string $avatar
 * @property array $abilities
 * @property array $accounts
 * @property array $address
 * @property array $contact
 * @property array $meta
 * @property array $notes
 * @property array $options
 * @property array $registration
 * @property array $roles
 * @property array $permissions
 * @property array $privileges
 * @property array $ui
 *
 * NOTE: This model does not include all available Laravel and Playground
 *       features. Read more on the Playground Wiki.
 *
 * @link https://github.com/gammamatrix/playground/wiki
 */
class User extends Authenticatable implements
    Contracts\Abilities,
    Contracts\Admin,
    Contracts\Privileges,
    Contracts\Role,
    Contracts\WithCreator,
    Contracts\WithMatrix,
    Contracts\WithModifier,
    MustVerifyEmail,
    Sanctum\Contracts\HasApiTokens
{
    use Concerns\Abilities;
    use Concerns\Admin;
    use Concerns\Privileges;
    use Concerns\Role;
    use Concerns\WithCreator;
    use Concerns\WithModifier;
    use HasFactory;
    use HasUuids;
    use Notifiable;
    use Sanctum\HasApiTokens;
    use Scopes\ScopeFilterColumns;
    use Scopes\ScopeFilterDates;
    use Scopes\ScopeFilterFlags;
    use Scopes\ScopeFilterIds;
    use Scopes\ScopeFilterTrash;
    use Scopes\ScopeSort;
    use SoftDeletes;

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
        'matrix' => '',
        'r' => null,
        'θ' => null,
        'ρ' => null,
        'φ' => null,
        'elevation' => null,
        'latitude' => null,
        'longitude' => null,
        'x' => null,
        'y' => null,
        'z' => null,
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

    protected $table = 'users';
}
