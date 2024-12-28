<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * \Playground\Models\Scopes\ScopeIsPublished
 */
trait ScopeIsPublished
{
    /**
     * @param Builder<Model> $query
     * @return Builder<Model>
     */
    public static function scopeIsPublished(
        Builder $query,
    ): Builder {
        $query->whereNotNull('published_at');

        return $query;
    }
}
