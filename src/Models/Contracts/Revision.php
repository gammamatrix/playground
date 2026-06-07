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
 *
 * @template TRelatedModel of \Illuminate\Database\Eloquent\Model
 * @template TDeclaringModel of \Illuminate\Database\Eloquent\Model
 *
 * @mixin Model
 */
interface Revision
{
    /**
     * Get the revisions of the model.
     *
     * @return HasMany<TRelatedModel, TDeclaringModel>
     */
    public function revisions(): HasMany;
}
