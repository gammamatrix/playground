<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

/**
 * \Playground\Models\Scopes\ScopeFilterTrash
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
