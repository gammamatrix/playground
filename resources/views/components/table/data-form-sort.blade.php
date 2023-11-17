<div class="input-group mb-3">

    <label class="input-group-text" for="{{$id}}_form_sort_0">Sort</label>

    @for ($i=0; $i < $sorts; $i++)
    <select class="form-select" id="{{$id}}_form_sort_{{$i}}" name="sort[]">

        <option value=""></option>

        @foreach ($sort as $column => $meta)
        <?php
        $selectedAsc = false;
        $selectedDesc = false;
        $selectedAsc = !empty($validated['sort']) && !empty($validated['sort'][$i]) && $validated['sort'][$i] === sprintf('%s', $column);
        $selectedDesc = !empty($validated['sort']) && !empty($validated['sort'][$i]) && $validated['sort'][$i] === sprintf('-%s', $column);
        ?>
        <option value="{{$column}}" {{$selectedAsc ? 'selected' : ''}}>↑ {{$meta['label']}}</option>
        <option value="-{{$column}}" {{$selectedDesc ? 'selected' : ''}}>↓ {{$meta['label']}}</option>
        @endforeach

    </select>
    @endfor

    <button type="submit" class="btn btn-success">
        Go
    </button>
</div>
