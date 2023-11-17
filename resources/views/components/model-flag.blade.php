<?php

$hasFlagOnFalseClass = !empty($columnMeta['onFalseClass'])
    && is_string($columnMeta['onFalseClass'])
;

$hasFlagOnFalseLabel = !empty($columnMeta['onFalseLabel'])
    && is_string($columnMeta['onFalseLabel'])
;

$hasFlagOnTrueClass = !empty($columnMeta['onTrueClass'])
    && is_string($columnMeta['onTrueClass'])
;

$hasFlagOnTrueLabel = !empty($columnMeta['onTrueLabel'])
    && is_string($columnMeta['onTrueLabel'])
;

$hasFlagOnFalse = $hasFlagOnFalseClass || $hasFlagOnFalseLabel;
$hasFlagOnTrue = $hasFlagOnTrueClass || $hasFlagOnTrueLabel;

if (!($hasFlagOnFalse || $hasFlagOnTrue)) {
    return;
}

// dd([
//     '__METHOD__' => __METHOD__,
//     '__FILE__' => __FILE__,
//     '__LINE__' => __LINE__,
//     '$columnMeta' => $columnMeta,
//     '$hasFlagOnFalse' => $hasFlagOnFalse,
//     '$hasFlagOnTrue' => $hasFlagOnTrue,
//     // '$key' => $key,
//     // '$column' => $column,
//     // '$records' => $records,
//     // 'old($column)' => old($column),
// ]);
?>
@if ($value)

@if ($hasFlagOnTrueClass)
<span class="{{$columnMeta['onTrueClass']}}"></span>
@endif

@if ($hasFlagOnTrueLabel)
{{$columnMeta['onTrueLabel']}}
@endif

@else

@if ($hasFlagOnFalseClass)
<span class="{{$columnMeta['onFalseClass']}}"></span>
@endif

@if ($hasFlagOnFalseLabel)
{{$columnMeta['onFalseLabel']}}
@endif

@endif
