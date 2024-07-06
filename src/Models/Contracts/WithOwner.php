<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Models\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * \Playground\Models\Contracts\WithOwner
 */
interface WithOwner
{
    /**
     * Get the owner of the model.
     *
     * @return HasOne<Model>
     */
    public function owner(): HasOne;
}
