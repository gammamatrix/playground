<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \Playground\Models\Contracts\WithCreator
 */
interface WithCreator
{
    /**
     * Get the creator of the model.
     */
    public function creator(): HasOne;
}
