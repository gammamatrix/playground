<?php
/**
 * Playground
 */
namespace Playground\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Ramsey\Uuid\Uuid;

/**
 * \Playground\Models\Traits\ScopeFilterIds
 */
trait ScopeFilterIds
{
    /**
     * @param array<string, mixed> $ids
     * @param array<string, mixed> $validated
     */
    public static function scopeFilterIds(
        Builder $query,
        array $ids,
        array $validated = []
    ): Builder {
        if (empty($validated['filter']) || ! is_array($validated['filter'])) {
            return $query;
        }

        $columns = [];

        $filter_type = 'string';

        foreach ($ids as $column => $meta) {
            if (empty(($column))
                || ! is_string($column)
                || ! preg_match('/^[a-z][a-z0-9_]+$/i', $column)
                || ! array_key_exists($column, $validated['filter'])
            ) {
                continue;
            }

            $filter_type = 'string';
            if (is_array($meta)
                && ! empty($meta['type'])
                && is_string($meta['type'])
            ) {
                $filter_type = $meta['type'];
            }

            if (is_null($validated['filter'][$column])) {
                // Handle null values
                $query->whereNull($column);
            } elseif (is_string($validated['filter'][$column])
                || is_numeric($validated['filter'][$column])
            ) {
                // Strings and numbers
                $query->where($column, $validated['filter'][$column]);
            } elseif (is_array($validated['filter'][$column])) {
                // Check for duplicates for the whereIn
                $columns[$column] = [];

                foreach ($validated['filter'][$column] as $id_index => $id) {
                    if (empty($id)) {
                        // Allows forms to pass empty fields and still validate.
                        continue;
                    }
                    if ($filter_type === 'string') {
                        if (! in_array(strval($id), $columns[$column])) {
                            $columns[$column][] = strval($id);
                        }
                    } elseif ($filter_type === 'uuid') {
                        if (Uuid::isValid($id) && ! in_array($id, $columns[$column])) {
                            $columns[$column][] = $id;
                        }
                    } elseif ($filter_type === 'integer') {
                        if (is_numeric($id) && $id > 0 && ! in_array(intval($id), $columns[$column])) {
                            $columns[$column][] = intval($id);
                        }
                    }
                }

                if (! empty($columns[$column])) {
                    $query->whereIn($column, $columns[$column]);
                }
            }
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$ids' => $ids,
        //     '$validated' => $validated,
        //     '$query->toSql()' => $query->toSql(),
        //     '$query->getBindings()' => $query->getBindings(),
        // ]);

        return $query;
    }
}
