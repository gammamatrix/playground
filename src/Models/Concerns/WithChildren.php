<?php
/**
 * Playground
 */
namespace Playground\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * \Playground\Models\Concerns\WithChildren
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
