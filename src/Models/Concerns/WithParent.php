<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \Playground\Models\Concerns\WithParent
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
