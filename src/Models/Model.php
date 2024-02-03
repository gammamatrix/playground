<?php
/**
 * Playground
 *
 */

namespace Playground\Models;

use Playground\Models\Interfaces\WithChildrenInterface;
use Playground\Models\Interfaces\WithCreatorInterface;
use Playground\Models\Interfaces\WithModifierInterface;
use Playground\Models\Interfaces\WithOwnerInterface;
use Playground\Models\Interfaces\WithParentInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * \Playground\Models\Model
 *
 */
abstract class Model extends UuidModel implements
    WithChildrenInterface,
    WithCreatorInterface,
    WithModifierInterface,
    WithOwnerInterface,
    WithParentInterface
{
    use HasFactory;
    use SoftDeletes;

    use Traits\ScopeSort;
    use Traits\ScopeFilterColumns;
    use Traits\ScopeFilterDates;
    use Traits\ScopeFilterFlags;
    use Traits\ScopeFilterIds;
    use Traits\ScopeFilterTrash;

    use Traits\WithChildren;
    use Traits\WithCreator;
    use Traits\WithModifier;
    use Traits\WithOwner;
    use Traits\WithParent;

    protected $perPage = 15;
}
