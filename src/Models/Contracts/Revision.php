<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Models\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * \Playground\Models\Contracts\Revision
 */
interface Revision
{
    /**
     * Get the revisions of the model.
     *
     * @return HasMany<Model>
     */
    public function revisions(): HasMany;
}
