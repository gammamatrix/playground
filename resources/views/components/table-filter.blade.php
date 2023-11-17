<div>
<?php
// dd([
//     '__METHOD__' => __METHOD__,
//     '__FILE__' => __FILE__,
//     '__LINE__' => __LINE__,
//     '$filters' => $filters,
//     '$validated' => $validated,
//     'request()->input()' => request()->input(),
// ]);
$trashed = false;
if ($trashable && !empty($validated) && !empty($validated['filter'])) {
    if (!empty($validated['filter']['trash'])) {
        if ('with' === $validated['filter']['trash']) {
            $trashed = 'with';
        } elseif ('only' === $validated['filter']['trash']) {
            $trashed = 'only';
        }
    }
}
?>
@if ($trashable)
<div class="input-group mb-3">
    <div class="form-check me-2">
        <input class="form-check-input" type="radio" name="filter[trash]" id="filter_trash" {{false === $trashed ? 'checked' : ''}} value="">
        <label class="form-check-label" for="filter_trash">
            Hide Trash
            <i class="fa-regular fa-trash-can"></i>
        </label>
    </div>
    <div class="form-check me-2">
        <input class="form-check-input" type="radio" name="filter[trash]" id="filter_trash_with" {{'with' === $trashed ? 'checked' : ''}} value="with">
        <label class="form-check-label" for="filter_trash_with">
            With Trash
            <i class="fa-solid fa-trash"></i>
        </label>
    </div>
    <div class="form-check me-2">
        <input type="hidden" name="filter[onlyTrash]" value="0">
        <input class="form-check-input" type="radio" name="filter[trash]" id="filter_trash_only" {{'only' === $trashed ? 'checked' : ''}} value="only">
        <label class="form-check-label" for="filter_trash_only">
            Only Trash
            <i class="fa-solid fa-trash-arrow-up"></i>
        </label>
    </div>
</div>
@endif

@foreach ($filters as $key => $meta)
@php
$hasValidated = !empty($validated['filter']) && !empty($validated['filter'][$key]);
$type = !empty($meta['type'])
    && in_array($meta['type'], [
        'boolean',
        'string',
        'uuid',
    ]) ? $meta['type'] : ''
;
// dump([
//     '__METHOD__' => __METHOD__,
//     '__FILE__' => __FILE__,
//     '__LINE__' => __LINE__,
//     '$hasValidated' => $hasValidated,
//     '$type' => $type,
//     '$meta' => $meta,
//     '$key' => $key,
// ]);
@endphp
<div class="input-group mb-3">

    @if ('boolean' === $type)

    <div class="form-check">
        <input type="checkbox" class="form-check-input" aria-label="" id="form_filter_{{$key}}" name="filter[{{$key}}]" value="1" {{$hasValidated ? 'checked' : ''}}>
        <label class="form-check-label" for="form_filter_{{$key}}">
            {{$meta['label']}}
        </label>
    </div>

    @elseif ('uuid' === $type)

        @if ($hasValidated)
        @if (is_array($validated['filter'][$key]))

            {{-- @foreach ($validated['filter'][$key] as $id)

            <input type="hidden" name="filter[{{$key}}][]" value="{{$id}}">

            <a href="{{request()->fullUrlWithoutQuery('filter.id')}}">
                {{$paginator->filter( function($value, $key) use ($id) {  return $value->id === $id;})->pluck('label')->first()}}
                <span class="fas fa-close"></span>
            </a>
            @endforeach --}}

        @elseif (is_string($validated['filter'][$key]))
            <input type="hidden" name="filter[{{$key}}][]" value="{{$alidated['filter'][$key]}}">
            <a href="{{request()->fullUrlWithoutQuery(sprintf('filter.id.%s', $validated['filter'][$key]));}}">
                {{$validated['filter'][$key]}}
                <span class="fas fas-close"></span>
            </a>
        @endif
        @endif

    @else

    <label class="input-group-text" for="form_per_page">
        {{$meta['label']}}
    </label>
    <?php
    // dump([
    //     '__METHOD__' => __METHOD__,
    //     '__FILE__' => __FILE__,
    //     '__LINE__' => __LINE__,
    //     '$key' => $key,
    //     '$type' => $type,
    //     '$validated' => $validated,
    //     'request()->input()' => request()->input(),
    // ]);
    ?>
    <input type="text" class="form-control" aria-label="" name="filter[{{$key}}]" value="{{$hasValidated ? $validated['filter'][$key] : ''}}">

    @endif

</div>

@endforeach

</div>
