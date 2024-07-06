<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Models\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \Playground\Models\Contracts\WithParent
 */
interface WithParent
{
    /**
     * Get the parent of the model.
     *
     * @return HasOne<Model>
     */
    public function parent(): HasOne;
}
