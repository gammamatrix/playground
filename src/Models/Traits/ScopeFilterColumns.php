<?php
/**
 * Playground
 */
namespace Playground\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

// use Illuminate\Support\Facades\Log;

/**
 * \Playground\Models\Traits\ScopeFilterColumns
 */
trait ScopeFilterColumns
{
    /**
     * @param array<string, mixed> $columns
     * @param array<string, mixed> $validated
     */
    public static function scopeFilterColumns(
        Builder $query,
        array $columns,
        array $validated = []
    ): Builder {
        if (empty($validated['filter']) || ! is_array($validated['filter'])) {
            return $query;
        }

        $filter_operator = null;
        $filter_value = null;

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
                || ! is_string($column)
                || ! preg_match('/^[a-z][a-z0-9_]+$/i', $column)
                || ! array_key_exists($column, $validated['filter'])
            ) {
                // Log::debug(__METHOD__, ['VALIDATION' => 'empty', '$column' => $column, '$validated' => $validated,]);
                continue;
            }

            if (! is_array($meta)) {
                $meta = [];
            }

            $filter_type = ! empty($meta['type']) && is_string($meta['type']) ? $meta['type'] : 'string';

            $filter_operator = null;
            $filter_value = null;

            if ($filter_type === 'boolean') {
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
                    if (! empty($validated['filter'][$column]['operator']) && array_key_exists(
                        strtoupper($validated['filter'][$column]['operator']),
                        $filter_operators
                    )) {
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

                if ($filter_operator === 'LIKE') {
                    $query->where($column, 'LIKE', $filter_value);
                } elseif ($filter_operator === 'NOTLIKE') {
                    $query->where(
                        $column,
                        'NOT LIKE',
                        is_string($filter_value) ? $filter_value : ''
                    );
                } elseif ($filter_operator === 'NULL') {
                    $query->whereNull($column);
                } elseif ($filter_operator === 'NOTNULL') {
                    $query->whereNotNull($column);
                } elseif ($filter_operator === 'BETWEEN') {
                    if (is_array($filter_value) && count($filter_value) === 2) {
                        $query->whereBetween($column, $filter_value);
                    }
                } elseif ($filter_operator === 'NOTBETWEEN') {
                    if (is_array($filter_value) && count($filter_value) === 2) {
                        $query->whereNotBetween($column, $filter_value);
                    }
                } else {
                    $query->where($column, $filter_operator, $filter_value);
                }
            }
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$columns' => $columns,
        //     '$validated' => $validated,
        //     '$query->toSql()' => $query->toSql(),
        //     '$query->getBindings()' => $query->getBindings(),
        // ]);
        return $query;
    }
}
