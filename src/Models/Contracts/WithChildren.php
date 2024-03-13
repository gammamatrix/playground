<?php
/**
 * Playground
 */
namespace Playground\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * \Playground\Models\Contracts\WithChildren
 */
interface WithChildren
{
    /**
     * Get the children under the model.
     */
    public function children(): HasMany;
}
