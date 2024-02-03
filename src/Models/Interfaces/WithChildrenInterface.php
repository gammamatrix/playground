<?php
/**
 * Playground
 */
namespace Playground\Models\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * \Playground\Models\Interfaces\WithChildrenInterface
 */
interface WithChildrenInterface
{
    /**
     * Get the children under the model.
     */
    public function children(): HasMany;
}
