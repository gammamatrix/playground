<?php
/**
 * Playground
 */
namespace Playground\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \Playground\Models\Traits\WithParent
 */
trait WithParent
{
    /**
     * Access the parent of this model.
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
