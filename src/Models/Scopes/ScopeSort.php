<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * \Playground\Models\Scopes\ScopeSort
 */
trait ScopeSort
{
    /**
     * @param Builder<Model> $query
     * @return Builder<Model>
     */
    public static function scopeSort(
        Builder $query,
        mixed $sort = null
    ): Builder {
        if (empty($sort)) {
            return $query;
        }

        $sorted = [];

        $csv = is_string($sort);

        if ($csv) {
            $sort = array_map('trim', explode(',', $sort));
        }

        if (is_array($sort)) {
            foreach ($sort as $key => $value) {
                if (is_null($value)) {
                    // Ignore invalid sorting
                    continue;
                }
                $direction = 'asc';
                if ($csv) {
                    $column = ltrim($value, '-');
                    $direction = strpos($value, '-') === 0 ? 'desc' : 'asc';
                } elseif (is_numeric($key)) {
                    $column = ltrim($value, '-');
                    $direction = strpos($value, '-') === 0 ? 'desc' : 'asc';
                } elseif (is_bool($value)) {
                    $column = $key;
                    $direction = $value ? 'asc' : 'desc';
                } else {
                    $column = $key;
                    if (is_string($value) &&
                        in_array(strtolower($value), ['asc', 'desc'])
                    ) {
                        $direction = strtolower($value);
                    }
                }

                if (! empty($column)
                    && ! in_array($column, $sorted)
                    && preg_match('/^[a-z][a-z0-9_]+$/i', $column)
                ) {
                    $sorted[] = $column;
                    $query->orderBy($column, $direction);
                }
            }
        }

        return $query;
    }
}
