<?php
/**
 * Playground
 */
namespace Playground\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Playground\Models\Interfaces\WithChildrenInterface;
use Playground\Models\Interfaces\WithCreatorInterface;
use Playground\Models\Interfaces\WithModifierInterface;
use Playground\Models\Interfaces\WithOwnerInterface;
use Playground\Models\Interfaces\WithParentInterface;

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
 */
abstract class Model extends UuidModel implements WithChildrenInterface, WithCreatorInterface, WithModifierInterface, WithOwnerInterface, WithParentInterface
{
    use HasFactory;
    use SoftDeletes;
    use Traits\ScopeFilterColumns;
    use Traits\ScopeFilterDates;
    use Traits\ScopeFilterFlags;
    use Traits\ScopeFilterIds;
    use Traits\ScopeFilterTrash;
    use Traits\ScopeSort;
    use Traits\WithChildren;
    use Traits\WithCreator;
    use Traits\WithModifier;
    use Traits\WithOwner;
    use Traits\WithParent;

    protected $perPage = 15;
}
