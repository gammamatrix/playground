<?php
/**
 * Playground
 */
namespace Playground\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * \Playground\Models\Traits\ScopeSort
 */
trait ScopeSort
{
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
