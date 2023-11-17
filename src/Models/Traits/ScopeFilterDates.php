<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \GammaMatrix\Playground\Models\Traits\scopeFilterDates
 *
 */
trait ScopeFilterDates
{
    public static function scopeFilterDates(
        Builder $query,
        array $dates,
        array $validated = []
    ): Builder {
        if (empty($validated['filter']) || !is_array($validated['filter'])) {
            return $query;
        }

        foreach ($dates as $column => $meta) {
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
                // \Log::debug(__METHOD__, ['VALIDATION' => 'empty', '$column' => $column, '$validated' => $validated,]);
                continue;
            }

            $filter_operator = null;
            $filter_value = null;
            $filter_parse = false;

            $filter_expects_array = false;

            if (is_null($validated['filter'][$column])) {
                if (!empty($meta['nullable'])) {
                    $filter_operator = 'NULL';
                } else {
                    continue;
                }
            } elseif (is_array($validated['filter'][$column])) {
                $filter_operator = array_key_exists('operator', $validated['filter'][$column])
                    && !empty($validated['filter'][$column]['operator'])
                    && is_string($validated['filter'][$column]['operator'])
                    && array_key_exists(
                        strtoupper($validated['filter'][$column]['operator']),
                        $this->filter_operators
                    )
                    ? strtoupper($validated['filter'][$column]['operator']) : null
                ;

                if ($filter_operator && in_array($filter_operator, [
                    'BETWEEN',
                    'NOTBETWEEN',
                ])) {
                    $filter_expects_array = true;
                }

                if (array_key_exists('value', $validated['filter'][$column])) {
                    if ($filter_expects_array
                        && !is_array($validated['filter'][$column]['value'])
                    ) {
                        // Skip column for operators that require an array of values.
                        // TODO add rules into $filter_operators
                        continue;
                    } elseif (is_string($validated['filter'][$column]['value'])) {
                        $filter_value = $validated['filter'][$column]['value'];
                    }
                }

                /**
                 * Steps:
                 * - Check if a parse option is provided.
                 * - Check for wildcard % in string.
                 * - If the string does not start with at least 2 digits, enable parsing.
                 */
                if (array_key_exists('parse', $validated['filter'][$column])) {
                    $filter_parse = !empty($validated['filter'][$column]['parse']);
                } elseif (is_string($filter_value)) {
                    if (strpos($filter_value, '%') !== false) {
                        if (!in_array($filter_operator, [
                            'LIKE',
                            'NOTLIKE'
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
            // dump([
                //     '__METHOD__' => __METHOD__,
                //     '__LINE__' => __LINE__,
                //     '$filter_operator' => $filter_operator,
                //     '$filter_value' => $filter_value,
                //     '$filter_parse' => $filter_parse,
                //     '$validated[filter][$column]' => $validated['filter'][$column],
            // ]);
            } elseif (is_string($validated['filter'][$column])
                && !empty($validated['filter'][$column])
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

            if ($filter_parse && !empty($filter_value)) {
                // $filter_value = date('Y-m-d H:i:s', strtotime($filter_value));
                $filter_value = Carbon::parse($filter_value)->format('Y-m-d H:i:s');
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

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$dates' => $dates,
        //     '$validated' => $validated,
        //     '$query->toSql()' => $query->toSql(),
        //     '$query->getBindings()' => $query->getBindings(),
        // ]);

        return $query;
    }
}
