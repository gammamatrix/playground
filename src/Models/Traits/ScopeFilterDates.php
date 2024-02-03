<?php
/**
 * Playground
 */
namespace Playground\Models\Traits;

use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * \Playground\Models\Traits\scopeFilterDates
 */
trait ScopeFilterDates
{
    public static function scopeFilterDates(
        Builder $query,
        array $dates,
        array $validated = []
    ): Builder {
        if (empty($validated['filter']) || ! is_array($validated['filter'])) {
            return $query;
        }

        $filter_operator = null;
        $filter_value = null;
        $filter_parse = false;

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

        foreach ($dates as $column => $meta) {

            if (empty(($column))
                || ! is_string($column)
                || ! preg_match('/^[a-z][a-z0-9_]+$/i', $column)
                || ! array_key_exists($column, $validated['filter'])
            ) {
                // Log::debug(__METHOD__, ['VALIDATION' => 'empty', '$column' => $column, '$validated' => $validated,]);
                continue;
            }

            $filter_operator = null;
            $filter_value = null;
            $filter_parse = false;

            $filter_expects_array = false;

            if (is_null($validated['filter'][$column])) {
                if (! empty($meta['nullable'])) {
                    $filter_operator = 'NULL';
                } else {
                    continue;
                }
            } elseif (is_array($validated['filter'][$column])) {

                if (! empty($validated['filter'][$column]['operator']) && array_key_exists(
                    strtoupper($validated['filter'][$column]['operator']),
                    $filter_operators
                )) {
                    $filter_operator = strtoupper($validated['filter'][$column]['operator']);
                }

                if (array_key_exists('value', $validated['filter'][$column])) {
                    $filter_value = $validated['filter'][$column]['value'];
                }

                /**
                 * Steps:
                 * - Check if a parse option is provided.
                 * - Check for wildcard % in string.
                 * - If the string does not start with at least 2 digits, enable parsing.
                 */
                if (array_key_exists('parse', $validated['filter'][$column])) {
                    $filter_parse = ! empty($validated['filter'][$column]['parse']);
                } elseif (is_string($filter_value)) {
                    if (strpos($filter_value, '%') !== false) {
                        if (! in_array($filter_operator, [
                            'LIKE',
                            'NOTLIKE',
                        ])) {
                            $filter_operator = 'LIKE';
                        }
                    } elseif (preg_match('/^\d\d/', $filter_value)) {
                        $filter_parse = false;
                    } else {
                        $filter_parse = true;
                    }
                }

                if (empty($filter_operator)) {
                    $filter_operator = '>=';
                }

            } elseif (is_string($validated['filter'][$column])
                && ! empty($validated['filter'][$column])
            ) {
                $filter_value = $validated['filter'][$column];
                if (strpos($validated['filter'][$column], '%') !== false) {
                    $filter_operator = 'LIKE';
                } else {
                    $filter_parse = true;
                    $filter_operator = '>=';
                }
            } else {
                // Skip other
                continue;
            }

            if ($filter_parse && ! empty($filter_value)) {
                try {
                    if (is_string($filter_value)) {
                        $filter_value = Carbon::parse($filter_value)->format('Y-m-d H:i:s');
                    } elseif (is_array($filter_value) && count($filter_value) === 2) {
                        $filter_value[0] = Carbon::parse($filter_value[0])->format('Y-m-d H:i:s');
                        $filter_value[1] = Carbon::parse($filter_value[1])->format('Y-m-d H:i:s');
                    }
                } catch (InvalidFormatException $th) {
                    // \Log::debug($th);
                    continue;
                }
            }

            if (is_null($filter_value) && empty($meta['nullable'])) {
                // Skip empty columns
                continue;
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
                $query->where(
                    $column,
                    $filter_operator ?? '=',
                    $filter_value
                );
            }
        }

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$dates' => $dates,
        //     '$validated' => $validated,
        //     '$query->toSql()' => $query->toSql(),
        //     '$query->getBindings()' => $query->getBindings(),
        //     '$filter_operator' => $filter_operator,
        //     '$filter_value' => $filter_value,
        //     '$filter_parse' => $filter_parse,
        // ]);

        return $query;
    }
}
