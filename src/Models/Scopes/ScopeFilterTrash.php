<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * \Playground\Models\Scopes\ScopeFilterTrash
 */
trait ScopeFilterTrash
{
    /**
     * @param Builder<Model> $query
     * @return Builder<Model>
     */
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
