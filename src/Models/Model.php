<?php

declare(strict_types=1);
/**
 * Playground
 */

namespace Playground\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * \Playground\Models\Model
 *
 * @method static Builder<static>|static query()
 * @method Builder<static> scopeFilterColumns(Builder<static> $builder, array<string, mixed> $columns, array<string, mixed> $validated = [])
 * @method Builder<static> scopeFilterDates(Builder<static> $builder, array<string, mixed> $dates, array<string, mixed> $validated = [])
 * @method Builder<static> scopeFilterFlags(Builder<static> $builder, array<string, mixed> $flags, array<string, mixed> $validated = [])
 * @method Builder<static> scopeFilterIds(Builder<static> $builder, array<string, mixed> $ids, array<string, mixed> $validated = [])
 * @method Builder<static> ScopeSort(Builder<static> $builder, array<int|string, mixed>|string|null $sort = null)
 * @method Builder<static>|static sort(mixed $sort = null)
 * @method Builder<static> scopeFilterTrash(Builder<static> $builder, string $visibility = null)
 *
 * @property ?Carbon $deleted_at
 * @property ?scalar $created_by_id
 * @property ?scalar $modified_by_id
 * @property ?scalar $owned_by_id
 * @property string $matrix
 * @property ?float $r
 * @property ?float $theta
 * @property ?float $rho
 * @property ?float $phi
 * @property ?float $elevation
 * @property ?float $latitude
 * @property ?float $longitude
 * @property ?int $x
 * @property ?int $y
 * @property ?int $z
 *
 * @mixin UuidModel
 */
abstract class Model extends UuidModel implements Contracts\WithMatrix
{
    use Scopes\ScopeFilterColumns;
    use Scopes\ScopeFilterDates;
    use Scopes\ScopeFilterFlags;
    use Scopes\ScopeFilterIds;
    use Scopes\ScopeFilterTrash;
    use Scopes\ScopeIsActive;
    use Scopes\ScopeIsNotClosed;
    use Scopes\ScopeSort;
    use SoftDeletes;

    protected $perPage = 15;

    /**
     * @return Attribute<string, string>
     */
    protected function labelOrTitle(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['label'] ?: $attributes['title'],
            // get: function (string|null $value, array $attributes) {
            //     return $attributes['label'] ?: $attributes['title'];
            // },
        );
    }

    /**
     * Access the parent of this model.
     *
     * @return HasOne<static, $this>
     */
    public function parent(): HasOne
    {
        return $this->hasOne(
            static::class,
            'id',
            'parent_id'
        );
    }

    /**
     * Access the children of this model.
     * `
     *
     * @return HasMany<static, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(
            static::class,
            'parent_id',
            'id'
        );
    }

    /**
     * @return HasOne<User, $this>
     */
    public function creator(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by_id');
    }

    /**
     * @return HasOne<User, $this>
     */
    public function modifier(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'modified_by_id');
    }

    /**
     * @return HasOne<User, $this>
     */
    public function owner(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'owned_by_id');
    }
}
