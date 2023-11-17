<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * \GammaMatrix\Playground\Models\Traits\ScopeFilterTrash
 *
 */
trait ScopeFilterTrash
{
    public static function scopeFilterTrash(
        Builder $query,
        ?string $visibility = null
    ): Builder {
        if ('with' === strtolower($visibility)) {
            $query->withTrashed();
        } elseif ('only' === strtolower($visibility)) {
            $query->onlyTrashed();
        }
        return $query;
    }
}
