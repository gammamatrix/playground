<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * \Playground\Models\Scopes\ScopeIsActive
 */
trait ScopeIsActive
{
    /**
     * @param Builder<Model> $query
     * @return Builder<Model>
     */
    public static function scopeIsActive(
        Builder $query,
    ): Builder {
        $query->where('active', 1);

        return $query;
    }
}
