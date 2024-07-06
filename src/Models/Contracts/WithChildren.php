<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Models\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * \Playground\Models\Contracts\WithChildren
 */
interface WithChildren
{
    /**
     * Get the children under the model.
     *
     * @return HasMany<Model>
     */
    public function children(): HasMany;
}
