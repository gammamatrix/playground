<?php
// dump([
//     '__METHOD__' => __METHOD__,
//     '__FILE__' => __FILE__,
//     '__LINE__' => __LINE__,
//     '$sort' => $sort,
//     '$validated' => $validated,
//     '$action' => $action,
//     '$id' => $id,
//     '$sorts' => $sorts,
// ]);

?>
{{-- <form method="get" action="{{$action}}" id="{{$id}}"> --}}

    @if (!empty($validated['perPage']))
    <input type="hidden" name="perPage" value="{{$validated['perPage']}}" />
    @endif

    @if (!empty($validated['page']))
    <input type="hidden" name="page" value="{{$validated['page']}}" />
    @endif

    <div class="input-group mb-3">

        <label class="input-group-text" for="{{$id}}_form_sort_0">Sort</label>

@for ($i=0; $i < $sorts; $i++)
<select class="form-select" id="{{$id}}_form_sort_{{$i}}" name="sort[]">

    <option value=""></option>

@foreach ($sort as $meta)
<?php
$selectedAsc = false;
$selectedDesc = false;
$selectedAsc = !empty($validated['sort']) && !empty($validated['sort'][$i]) && $validated['sort'][$i] === sprintf('-%s', $meta['column']);
$selectedDesc = !empty($validated['sort']) && !empty($validated['sort'][$i]) && $validated['sort'][$i] === sprintf('%s', $meta['column']);
?>
<option value="-{{$meta['column']}}" {{$selectedAsc ? 'selected' : ''}}>↑ {{$meta['label']}}</option>
<option value="{{$meta['column']}}" {{$selectedDesc ? 'selected' : ''}}>↓ {{$meta['label']}}</option>
@endforeach

</select>
@endfor

        <button type="submit" class="btn btn-primary">
            Go
        </button>
    </div>
{{-- </form> --}}
