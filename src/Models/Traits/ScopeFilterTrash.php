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
        if ($visibility && strtolower($visibility) === 'with') {
            $query->withTrashed();
        } elseif ($visibility && strtolower($visibility) === 'only') {
            $query->onlyTrashed();
        }

        return $query;
    }
}
