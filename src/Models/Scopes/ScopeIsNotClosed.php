<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * \Playground\Models\Scopes\ScopeIsNotClosed
 */
trait ScopeIsNotClosed
{
    /**
     * @param Builder<Model> $query
     * @return Builder<Model>
     */
    public static function scopeIsNotClosed(
        Builder $query,
    ): Builder {
        $query->whereNull('closed_at');

        return $query;
    }
}
