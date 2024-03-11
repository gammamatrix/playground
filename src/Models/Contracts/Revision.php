<?php
/**
 * Playground
 */
namespace Playground\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * \Playground\Models\Contracts\WithRevisionInterface
 */
interface WithRevisionInterface
{
    /**
     * Get the revisions of the model.
     */
    public function revisions(): HasMany;
}
