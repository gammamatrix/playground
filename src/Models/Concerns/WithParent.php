<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

/**
 * \Playground\Models\Concerns\WithParent
 */
trait WithParent
{
    /**
     * Access the parent of this model.
     *
     * @return HasOne<Model>
     */
    public function parent(): HasOne
    {
        return $this->hasOne(
            static::class,
            'id',
            'parent_id'
        );
    }
}
