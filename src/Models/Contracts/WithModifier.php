<?php
/**
 * Playground
 */
namespace Playground\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \Playground\Models\Contracts\WithModifier
 */
interface WithModifier
{
    /**
     * Get the modifier of the model.
     */
    public function modifier(): HasOne;
}
