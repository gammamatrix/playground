<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

// use Illuminate\Support\Facades\Log;

/**
 * \GammaMatrix\Playground\Models\Traits\ScopeFilterColumns
 *
 */
trait ScopeFilterColumns
{
    public static function scopeFilterColumns(
        Builder $query,
        array $columns,
        array $validated = []
    ): Builder {
        if (empty($validated['filter']) || !is_array($validated['filter'])) {
            return $query;
        }

        $filter_operators = [
            '|' => [],
            '&' => [],
            '=' => [],
            '!=' => [],
            '<>' => [],
            '<=>' => [],
            '<' => [],
            '<=' => [],
            '>=' => [],
            'NULL' => [],
            'NOTNULL' => [],
            'LIKE' => [],
            'NOTLIKE' => [],
            'BETWEEN' => [],
            'NOTBETWEEN' => [],
        ];

        foreach ($columns as $column => $meta) {
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '__LINE__' => __LINE__,
            //     '$column' => $column,
            // ]);
            if (empty(($column))
                || !is_string($column)
                || !preg_match('/^[a-z][a-z0-9_]+$/i', $column)
                || !array_key_exists($column, $validated['filter'])
            ) {
                // Log::debug(__METHOD__, ['VALIDATION' => 'empty', '$column' => $column, '$validated' => $validated,]);
                continue;
            }

            $filter_type = !empty($meta['type']) && is_string($meta['type']) ? $meta['type'] : 'string';

            $filter_operator = null;
            $filter_value = null;
            $filter_parse = false;

            if ('boolean' === $filter_type) {
                $filter_operator = 'BOOLEAN';
                $filter_value = (bool) $validated['filter'][$column];
                $columns[$column] = [
                    'column' => $column,
                    'operator' => $filter_operator,
                    'value' => $filter_value,
                ];
                $query->where($column, $filter_value);
            } else {
                if (is_array($validated['filter'][$column])) {
                    if (!empty($validated['filter'][$column]['operator'])
                        && array_key_exists(strtoupper($validated['filter'][$column]['operator']), $filter_operators)
                    ) {
                        $filter_operator = strtoupper($validated['filter'][$column]['operator']);
                    }

                    if (array_key_exists('value', $validated['filter'][$column])) {
                        $filter_value = $validated['filter'][$column]['value'];
                    }
                } else {
                    $filter_value = $validated['filter'][$column];
                }

                if (is_null($filter_value) && empty($meta['nullable'])) {
                    // Skip empty columns
                    continue;
                }

                if (empty($filter_operator)) {
                    $filter_operator = 'LIKE';
                }

                if ('LIKE' === $filter_operator) {
                    $query->where($column, 'LIKE', $filter_value);
                } elseif ('NOTLIKE' === $filter_operator) {
                    $query->where(
                        $column,
                        'NOT LIKE',
                        is_string($filter_value) ? $filter_value : ''
                    );
                } elseif ('NULL' === $filter_operator) {
                    $query->whereNull($column);
                } elseif ('NOTNULL' === $filter_operator) {
                    $query->whereNotNull($column);
                } elseif ('BETWEEN' === $filter_operator) {
                    if (is_array($filter_value) && 2 === count($filter_value)) {
                        $query->whereBetween($column, $filter_value);
                    }
                } elseif ('NOTBETWEEN' === $filter_operator) {
                    if (is_array($filter_value) && 2 === count($filter_value)) {
                        $query->whereNotBetween($column, $filter_value);
                    }
                } else {
                    $query->where($column, $filter_operator, $filter_value);
                }
            }
        }

        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$dates' => $dates,
        //     '$validated' => $validated,
        //     '$query->toSql()' => $query->toSql(),
        //     '$query->getBindings()' => $query->getBindings(),
        // ]);
        return $query;
    }
}
