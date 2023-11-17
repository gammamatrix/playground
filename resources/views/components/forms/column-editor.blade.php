<?php
// $label = isset($label) && is_string($label) ? $label : '';
// $column = isset($column) && is_string($column) ? $column : '';
$oldValue = old($column);
$hasRules = isset($rules) && is_array($rules) && !empty($rules);
$hasError = $errors->get($column);

$advanced = isset($advanced) && $advanced ? 'form-advanced' : '';
// $klass = isset($klass) && is_string($klass) ? $klass : '';
$withoutMargin = isset($withoutMargin) && $withoutMargin ? '' : 'mb-3';

$maxlength = $hasRules
    && isset($rules['maxlength'])
    && is_numeric($rules['maxlength'])
    && $rules['maxlength'] > 0
    ? sprintf('maxlength="%1$d" ', $rules['maxlength'])
    : ''
;

$required = $hasRules
    && isset($rules['required'])
    && is_bool($rules['required'])
    && $rules['required']
    ? 'required '
    : ''
;

if (is_bool($disabled) && $disabled) {
    $disabled = 'disabled';
} else {
    $disabled = '';
}

if (is_bool($readonly) && $readonly) {
    $readonly = 'readonly';
} else {
    $readonly = '';
}

$attributes = trim(implode(' ', array_filter([
    $readonly,
    $disabled,
    $maxlength,
    $required,
    sprintf('id="form-input-%1$s"', $column),
    sprintf('name="%1$s"', $column),
    sprintf('class="%1$s"', implode(' ', ['form-control'])),
    sprintf('aria-label="%1$s"', $label),
    sprintf('aria-describedby="form-input-%1$s"', $column),
])));

// dump([
//     '__METHOD__' => __METHOD__,
//     '__FILE__' => __FILE__,
//     '__LINE__' => __LINE__,
//     '$column' => $column,
//     '$attributes' => $attributes,
//     'old($column)' => old($column),
// ]);
?>
<div class="{{trim(sprintf('%s %s %s', $withoutMargin, $advanced, $class))}}">

    <label for="form-input-{{$column}}" class="form-label">{{$label}}</label>

    @if(empty($column))
    <div class="alert alert-danger">Expecting a column for the form editor.</div>
    @endif

    <textarea {!!$attributes!!}>{!! $oldValue !!}</textarea>

    @if($described)
    <small id="form-input-help-{{$column}}" class="form-text text-muted">{!!$described!!}</small>
    @endif

    {{ $slot }}
</div>
