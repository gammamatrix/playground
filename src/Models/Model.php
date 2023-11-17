<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Models;

use GammaMatrix\Playground\Models\Interfaces\WithChildrenInterface;
use GammaMatrix\Playground\Models\Interfaces\WithCreatorInterface;
use GammaMatrix\Playground\Models\Interfaces\WithModifierInterface;
use GammaMatrix\Playground\Models\Interfaces\WithOwnerInterface;
use GammaMatrix\Playground\Models\Interfaces\WithParentInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * \GammaMatrix\Playground\Models\Model
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
