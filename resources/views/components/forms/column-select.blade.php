<?php
// $label = isset($label) && is_string($label) ? $label : '';
// $column = isset($column) && is_string($column) ? $column : '';
// $default = isset($default) && is_bool($default) && $default;
// $records = isset($records) ? $records : [];
// $id = isset($id) && is_string($id) && !empty($id) ? $id : 'id';
// $key = isset($key) && is_string($key) && !empty($key) ? $key : 'label';
$oldValue = old($column);
$withoutMargin = isset($withoutMargin) && $withoutMargin ? '' : 'mb-3';
// $class = isset($class) && is_string($class) ? $class : '';
// $errorMessage = isset($errorMessage) && is_string($errorMessage) ? $errorMessage : '';
// $disabled = isset($disabled) && is_bool($disabled) ? $disabled : null;
// $readonly = isset($readonly) && is_bool($readonly) ? $readonly : null;

$hasRules = isset($rules) && is_array($rules) && !empty($rules);
$hasError = $errors->get($column);

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
    $required,
    sprintf('id="form-input-%1$s"', $column),
    sprintf('name="%1$s"', $column),
    // sprintf('class="%1$s"', implode(' ', ['form-control'])),
    sprintf('aria-label="%1$s"', $label),
    sprintf('aria-describedby="form-input-%1$s"', $column),
])));

// dump([
//     '__METHOD__' => __METHOD__,
//     '__FILE__' => __FILE__,
//     '__LINE__' => __LINE__,
//     '$key' => $key,
//     '$column' => $column,
//     '$records' => $records,
//     'old($column)' => old($column),
// ]);
if(empty($column)) {
    echo 'Expecting a column for the form select.';
}
?>
<div class="{{trim(sprintf('%s %s %s', $withoutMargin, $advanced, $class))}}">
    <div class="input-group my-3">
        @if ($label)
        <label class="input-group-text" for="form-input-{{$column}}">{{$label}}</label>
        @endif
        <!-- <select class="form-select @error($column) is-invalid @enderror" id="form-input-{{$column}}" name="{{$column}}" value="{{$oldValue}}" {!!$required!!}{!!$attributes!!}> -->
        <select class="form-select @error($column) is-invalid @enderror" value="{{$oldValue}}" {!!$required!!}{!!$attributes!!}>
        @if ($default)
        <option @if (empty($oldValue)) selected @endif></option>
        @endif
        @foreach ($records as $record)
        <option value="{{$record[$id]}}" @if ($record[$id] === $oldValue) selected @endif>{{$record[$key]}}</option>
        @endforeach
        </select>
    </div>
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
