<?php
/**
 * Playground
 */
namespace Playground\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * \Playground\Models\Traits\WithChildren
 */
trait WithChildren
{
    /**
     * Access the children of this model.
     */
    public function children(): HasMany
    {
        return $this->hasMany(
            static::class,
            'parent_id',
            'id'
        );
    }
}
