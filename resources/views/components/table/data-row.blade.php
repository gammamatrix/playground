@foreach ($columns as $column => $columnMeta)
<?php
$value = '';

/**
 * @var string $accessor The accessor to use for data.
 */
$accessor = isset($columnMeta['accessor']) && is_string($columnMeta['accessor']) ? $columnMeta['accessor'] : '';

/**
 * @var string $property The property to use for data.
 */
$property = isset($columnMeta['property']) && is_string($columnMeta['property']) ? $columnMeta['property'] : '';

$columnMeta['class'] = isset($columnMeta['class']) ? $columnMeta['class'] : '';
if (isset($columnMeta['classes']) && is_array($columnMeta['classes'])) {
    $columnMeta['class'] .= empty($columnMeta['class']) ? $columnMeta['class'] : ' ' . $columnMeta['class'];
}
$columnMeta['linkType'] = isset($columnMeta['linkType']) ? $columnMeta['linkType'] : '';
$columnMeta['linkRoute'] = isset($columnMeta['linkRoute']) ? $columnMeta['linkRoute'] : '';

$columnMeta['type'] = isset($columnMeta['type']) ? $columnMeta['type'] : '';
$columnMeta['html'] = isset($columnMeta['html']) && is_bool($columnMeta['html']) ? $columnMeta['html'] : false;
$columnMeta['action'] = isset($columnMeta['action']) ? $columnMeta['action'] : '';

$columnMeta['showSpec'] = isset($columnMeta['showSpec']) && is_bool($columnMeta['showSpec']) ? $columnMeta['showSpec'] : false;

$columnMeta['filter'] = isset($columnMeta['filter']) && is_string($columnMeta['filter']) && !empty($record[$column]) ? $columnMeta['filter'] : null;

if ($columnMeta['filter']) {
    $columnMeta['filter_id'] = empty($record[$columnMeta['filter']]) ? '' : $record[$columnMeta['filter']];
    $columnMeta['filter_css_id'] = 'filter_' . $columnMeta['filter'] . '_' . $columnMeta['filter_id'];
    $columnMeta['filter_name'] = 'filter[' . $columnMeta['filter'] . '][]';
    $columnMeta['filter_checked'] = !empty($validated['filter']) && !empty($validated['filter'][$columnMeta['filter']]) && is_array($validated['filter'][$columnMeta['filter']]) && in_array($record[$columnMeta['filter']], $validated['filter'][$columnMeta['filter']]) ? 'checked' : '';
}

/**
 * @var string $link The link to use for the column's data.
 */
$link = '';

$preferLinkSlug = 'slug' === $columnMeta['linkType'];
$preferLinkId = 'id' === $columnMeta['linkType'];
$preferLinkGo = 'go' === $columnMeta['linkType'];
$isUrlLink = 'url' === $columnMeta['linkType'];

/**
 * @var string $isDate Is the column a datetime column?
 */
$isDate = 'date' === $columnMeta['type'];

/**
 * @var string $isFk Is the column a foreign key?
 */
$isFk = 'fk' === $columnMeta['linkType'];
// The foreign key needs a property to access.
$isFk = $isFk && isset($columnMeta['property']) && !empty($columnMeta['property']);
if ($preferLinkSlug) {
    if (!isset($record['slug']) || empty($record['slug'])) {
        // No slug available, use id for detail page instead.
        $columnMeta['linkType'] = $routeParameterKey;
        $preferSlug = false;
    }
}
// dd([
//     '__METHOD__' => __METHOD__,
//     '__FILE__' => __FILE__,
//     '__LINE__' => __LINE__,
//     '$value' => $value,
//     '$column' => $column,
//     '$columnMeta' => $columnMeta,
//     // '$hasLink' => $hasLink,
//     '$isFk' => $isFk,
//     '$isUrlLink' => $isUrlLink,
//     '$link' => $link,
//     '$record' => $record,
//     '$datum' => $datum,
// ]);

// Check for slug link first.
if (empty($columnMeta['linkRoute'])) {
    $link = '';
} elseif ($preferLinkSlug) {
    $link = route($columnMeta['linkRoute'], ['slug' => $record['slug']]);
} elseif ($preferLinkId) {
    $link = route($columnMeta['linkRoute'], [$routeParameter => $record[$routeParameterKey]]);
} elseif ($preferLinkGo) {
    $link = route($columnMeta['linkRoute'], ['go' => $record[$routeParameterKey]]);
} elseif ($isFk) {
    $link = empty($record[$column]) ? '' : route($columnMeta['linkRoute'], [$routeParameter => $record[$column]]);
}

if ($isUrlLink) {
    $link = empty($record[$column]) ? '' : $record[$column];
    $value = $link;
}
$hasLink = !empty($link);
// dump([
//     '__METHOD__' => __METHOD__,
//     '__FILE__' => __FILE__,
//     '__LINE__' => __LINE__,
//     '$value' => $value,
//     '$column' => $column,
//     '$columnMeta' => $columnMeta,
//     '$hasLink' => $hasLink,
//     '$isFk' => $isFk,
//     '$isUrlLink' => $isUrlLink,
//     '$link' => $link,
//     '$record' => $record,
//     '$datum' => $datum,
// ]);

if ($isFk && !empty($accessor)) {
    $fkModel = $datum->{$accessor}()->first();
    if ($fkModel) {
        $fkModelData = $fkModel->toArray();
        if (!empty($property) && isset($fkModelData[$property])) {
            $value = $fkModelData[$property];
        }
    }
// dump([
    //     '__METHOD__' => __METHOD__,
    //     '__FILE__' => __FILE__,
    //     '__LINE__' => __LINE__,
    //     '$value' => $value,
    //     '$column' => $column,
    //     '$columnMeta' => $columnMeta,
    //     '$hasLink' => $hasLink,
    //     '$link' => $link,
    //     '$record' => $record,
    //     '$datum' => $datum,
    //     '$fkModel' => $fkModel ? $fkModel->toArray() : $fkModel,
// ]);
} elseif ($columnMeta['showSpec']) {
    // Get the label of the type.
    $accessor = empty($accessor) ? 'spec' : $accessor;
    $property = empty($property) ? 'label' : $property;
    $value = $datum->{$accessor}[$property];
} else {
    // Set the value of the column.
    $value = $datum[$column];
}

if (is_array($value)) {
    if ('implode' === $columnMeta['action']) {
        $value = implode(', ', $value);
    } elseif ('json' === $columnMeta['action']) {
        $value = json_encode($value);
    } else {
        // Do nothing for now.
    }
}

$isFlag = isset($columnMeta['flag']) && is_bool($columnMeta['flag']) && $columnMeta['flag'];

// dump([
//     '__METHOD__' => __METHOD__,
//     '__FILE__' => __FILE__,
//     '__LINE__' => __LINE__,
//     '$column' => $column,
//     '$columnMeta' => $columnMeta,
//     '$hasLink' => $hasLink,
//     '$record' => $record,
//     '$datum' => $datum,
//     '$routeDelete' => $routeDelete,
//     '$routeDeleteRelationship' => $routeDeleteRelationship,
//     '$routeDeleteRelationshipId' => $routeDeleteRelationshipId,
//     '$modelActions' => $modelActions,
// ]);

?>
<td class="{{ !empty($columnMeta['hide-sm']) ? 'd-none d-sm-table-cell' : '' }}{{ $columnMeta['class'] }}">
    @if ($hasLink)
        <a href="{{ $link }}">
    @endif

    @if ($isFlag)
        <x-playground::model-flag :$columnMeta :$value />
        <!-- @modelFlag($columnMeta + ['value' => $value]) -->
    @elseif ($columnMeta['html'])
        {!! $value !!}
    @elseif ($isDate)
        <time datetime="{{ $value }}">{{ $value }}</time>
    @else
        {{ $value }}
    @endif

    @if ($hasLink)
        </a>
    @endif

    @if ($columnMeta['filter'])
        <div class="form-check">
            @php
                $filter_table_id = request()->fullUrlWithoutQuery('filter.id');
                if (!str_contains($filter_table_id, '?')) {
                    $filter_table_id .= '?';
                } else {
                    $filter_table_id .= '&';
                }
            @endphp
            <a href="{{ $filter_table_id . 'filter[id][]=' . $columnMeta['filter_id'] }}" class="btn btn-outline-warning">
                <span class="fas fa-filter"><span>
            </a>
            {{-- <input class="form-check-input" type="checkbox" value="{{$columnMeta['filter_id']}}" name="{{$columnMeta['filter_name']}}" id="{{$columnMeta['filter_css_id']}}" {{$columnMeta['filter_checked']}}> --}}
            {{-- <label class="form-check-label" for="{{$columnMeta['filter_id']}}">
            <span class="fas fa-filter"><span>
        </label> --}}
        </div>
    @endif

</td>
@endforeach
