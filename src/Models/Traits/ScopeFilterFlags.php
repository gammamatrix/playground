<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * \GammaMatrix\Playground\Models\Traits\ScopeFilterFlags
 *
 */
trait ScopeFilterFlags
{
    public static function scopeFilterFlags(
        Builder $query,
        array $flags,
        array $validated = []
    ): Builder {
        if (empty($validated['filter']) || !is_array($validated['filter'])) {
            return $query;
        }

        foreach ($flags as $column => $meta) {
            if (!empty(($column))
                && is_string($column)
                && preg_match('/^[a-z][a-z0-9_]+$/i', $column)
                && array_key_exists($column, $validated['filter'])
                // NULL means either true or false is acceptable
                && !is_null($validated['filter'][$column])
            ) {
                $query->where($column, !empty($validated['filter'][$column]));
            }
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$flags' => $flags,
        //     '$validated' => $validated,
        //     '$query->toSql()' => $query->toSql(),
        //     '$query->getBindings()' => $query->getBindings(),
        // ]);

        return $query;
    }
}
