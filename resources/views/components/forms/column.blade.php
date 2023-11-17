<?php
// $default = isset($default) ? $default : null;
// $type = isset($type) && is_string($type) ? $type : 'text';
// $label = isset($label) && is_string($label) ? $label : '';
// $column = isset($column) && is_string($column) ? $column : '';
$oldValue = old($column);
$hasRules = isset($rules) && is_array($rules) && !empty($rules);
$withoutMargin = isset($withoutMargin) && $withoutMargin ? '' : 'mb-3';

if ('datetime-local' === $type && $oldValue) {
    $oldValue = Carbon\Carbon::parse($oldValue)->format('Y-m-d\TH:i:s');
}
// dump([
//     '$column' => $column,
//     '$oldValue' => $oldValue,
//     'old()' => old(),
// ]);
if (empty($oldValue) && !is_null($default)) {
    $oldValue = $default;
}
$min = $hasRules && isset($rules['min']) ? $rules['min'] : NULL;
$max = $hasRules && isset($rules['max']) ? $rules['max'] : NULL;

$step = !empty($step) && is_numeric($step) && in_array($type, [
    'number'
]) ? $step : NULL;


$advanced = isset($advanced) && $advanced ? 'form-advanced' : '';
// $class = isset($class) && is_string($class) ? $class : '';

// $described = isset($described) && is_string($described) ? $described : '';
// $pattern = isset($pattern) && is_string($pattern) ? $pattern : '';
// $errorMessage = isset($errorMessage) && is_string($errorMessage) ? $errorMessage : '';
// $placeholder = isset($placeholder) && (is_string($placeholder) || is_bool($placeholder)) ? $placeholder : false;
// $autocomplete = isset($autocomplete) && is_bool($autocomplete) ? $autocomplete : null;
// $disabled = isset($disabled) && is_bool($disabled) ? $disabled : null;
// $readonly = isset($readonly) && is_bool($readonly) ? $readonly : null;

if (is_bool($autocomplete)) {
    $autocomplete = sprintf('autocomplete="%1$s" ', ($autocomplete ? 'on' : 'off'));
} else {
    $autocomplete = '';
}

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

if (is_string($placeholder)) {
    $placeholder = sprintf('placeholder="%1$s" ', $placeholder);
} elseif ($placeholder) {
    $placeholder = sprintf('placeholder="%1$s" ', $label);
} else {
    $placeholder = '';
}

if (!empty($pattern)) {
    $pattern = sprintf('pattern="%1$s" ', $pattern);
}

if (!is_null($min)) {
    if ('datetime-local' === $type) {
        $min = date('Y-m-d\Th:i:s', strtotime($min));
    }
    $min = sprintf('min="%1$s" ', $min);
} else {
    $min = '';
}

if (!is_null($max)) {
    if ('datetime-local' === $type) {
        $max = date('Y-m-d\TH:i:s', strtotime($max));
    }
    $max = sprintf('max="%1$s" ', $max);
} else {
    $max = '';
}

if (!is_null($step)) {
    $step = sprintf('step="%1$s" ', $step);
} else {
    $step = '';
}


$hasError = $errors->get($column);

// if (!empty($describedby) && !empty($described)) {
//     $describedby = sprintf('aria-describedby="%1$s" ', $describedby);
// }

$describedby = trim(implode(' ', array_filter([
    sprintf('form-input-%1$s', $column),
    $hasError ? sprintf('form-input-error-%1$s', $column) : '',
    $described ? sprintf('form-input-help-%1$s', $column) : '',
])));

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

$attributes = trim(implode(' ', array_filter([
    $readonly,
    $disabled,
    $pattern,
    $maxlength,
    $placeholder,
    $autocomplete,
    $min,
    $max,
    $step,
    $required,
    sprintf('id="form-input-%1$s"', $column),
    sprintf('name="%1$s"', $column),
    // sprintf('class="%1$s"', implode(' ', ['form-control'])),
    sprintf('aria-label="%1$s"', $label),
    // sprintf('aria-describedby="form-input-%1$s"', $column),
])));
// $required = '';
// if ('some-column' === $column) {
// dd([
//     '__METHOD__' => __METHOD__,
//     '__FILE__' => __FILE__,
//     '__LINE__' => __LINE__,
//     '$column' => $column,
//     'old($column)' => old($column),
//     '$hasError' => $hasError,
//     '$describedby' => $describedby,
//     '$described' => $described,
//     '$attributes' => $attributes,
// ]);
// }
// dd([
//     '__METHOD__' => __METHOD__,
//     '__FILE__' => __FILE__,
//     '__LINE__' => __LINE__,
//     '$column' => $column,
//     'old($column)' => old($column),
//     '$hasError' => $hasError,
//     '$describedby' => $describedby,
//     '$described' => $described,
//     '$attributes' => $attributes,
//     '$class' => $class,
// ]);
?>
<div class="{{trim(sprintf('%s %s %s', $withoutMargin, $advanced, $class))}}">

    <label for="form-input-{{$column}}" class="form-label">{{$label}}</label>

    @if(empty($column))
    <div class="alert alert-danger">Expecting a column for the form input.</div>
    @endif

    <!-- <input type="{{$type}}" class="form-control @error($column) is-invalid @enderror" name="{{$column}}" id="form-input-{{$column}}" aria-describedby="{{$describedby}}" value="{{$oldValue}}" {!!$attributes!!}> -->
    <input type="{{$type}}" class="form-control @error($column) is-invalid @enderror" value="{{$oldValue}}" aria-describedby="{{$describedby}}" {!!$attributes!!}>

    @if ($errorMessage)
    <div class="invalid-feedback">
        {{ $errorMessage }}
    </div>
    @else
    @error($column)
    <div class="invalid-feedback" id="form-input-error-{{$column}}">{{ $message }}</div>
    @enderror
    @endif

    @if($described)
    <small id="form-input-help-{{$column}}" class="form-text text-muted">{!!$described!!}</small>
    @endif

    {{ $slot }}
</div>
