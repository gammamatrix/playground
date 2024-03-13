<?php
/**
 * Playground
 */
namespace Playground\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \Playground\Models\Contracts\WithOwner
 */
interface WithOwner
{
    /**
     * Get the owner of the model.
     */
    public function owner(): HasOne;
}
