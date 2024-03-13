<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * \Playground\Models\Model
 *
 * @method static Builder|static query()
 * @method Builder<static> scopeFilterDates(Builder $builder, array $dates, array $validated = [])
 * @method Builder<static> scopeFilterColumns(Builder $builder, array $columns, array $validated = [])
 * @method Builder<static> scopeFilterFlags(Builder $builder, array $flags, array $validated = [])
 * @method Builder<static> scopeFilterIds(Builder $builder, array $ids, array $validated = [])
 * @method Builder<static> ScopeSort(Builder $builder, array|string $sort = null)
 * @method Builder|static sort(mixed $sort = null)
 * @method Builder<static> scopeFilterTrash(Builder $builder, string $visibility = null)
 *
 * @property ?Carbon $deleted_at
 * @property string $created_by_id
 * @property string $modified_by_id
 * @property string $owned_by_id
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
 */
abstract class Model extends UuidModel implements
    Contracts\WithChildren,
    Contracts\WithCreator,
    Contracts\WithMatrix,
    Contracts\WithModifier,
    Contracts\WithOwner,
    Contracts\WithParent
{
    use Concerns\WithChildren;
    use Concerns\WithCreator;
    use Concerns\WithModifier;
    use Concerns\WithOwner;
    use Concerns\WithParent;
    use HasFactory;
    use Scopes\ScopeFilterColumns;
    use Scopes\ScopeFilterDates;
    use Scopes\ScopeFilterFlags;
    use Scopes\ScopeFilterIds;
    use Scopes\ScopeFilterTrash;
    use Scopes\ScopeSort;
    use SoftDeletes;

    protected $perPage = 15;
}
