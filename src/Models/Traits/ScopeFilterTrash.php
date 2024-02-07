<?php
/**
 * Playground
 */
namespace Playground\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * \Playground\Models\Traits\ScopeFilterTrash
 */
trait ScopeFilterTrash
{
    public static function scopeFilterTrash(
        Builder $query,
        string $visibility = null
    ): Builder {
        if ($visibility && strtolower($visibility) === 'with'
            && is_callable([$query, 'withTrashed'])
        ) {
            $query->withTrashed();
        } elseif ($visibility && strtolower($visibility) === 'only'
            && is_callable([$query, 'onlyTrashed'])
        ) {
            $query->onlyTrashed();
        }

        return $query;
    }
}
