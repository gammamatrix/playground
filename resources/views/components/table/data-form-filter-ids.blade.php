<fieldset class="mb-3" id="{{$id}}-fieldset-filter-ids">

    <legend>
        <div class="float-end">
            <button type="submit" class="btn btn-success me-2">
                <i class="fa-solid fa-filter"></i>
                <span class="d-none d-sm-inline">Go</span>
            </button>
            <button class="btn btn-warning btn-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#{{$id}}-fieldset-filter-ids .container" aria-expanded="true" aria-controls="{{$id}}-fieldset-filter-ids .container">
                <i class="fa-solid fa-eye-slash"></i>
                <i class="fa-solid fa-fingerprint"></i>
            </button>
        </div>
        Filter IDs
    </legend>

    <div class="container collapse show">
        <div class="row">

            @foreach ($meta['ids'] as $column => $meta_column)

            @php
            $hasValidated = !empty($validated['filter']) && !empty($validated['filter'][$column]);
            $type = !empty($meta_column['type'])
                && in_array($meta_column['type'], [
                    'boolean',
                    'string',
                    'uuid',
                ]) ? $meta_column['type'] : ''
            ;
            $filter_ids_value_type = $hasValidated && is_array($validated['filter'][$column]) ? 'array' : '';
            if ('array' === $filter_ids_value_type) {
                $filter_ids_values = $hasValidated ? $validated['filter'][$column] : [];
            } else {
                $filter_ids_values = $hasValidated ? [$validated['filter'][$column]] : [];
            }
            @endphp

            <div class="col-12 col-md-6 col-lg-4">

                <fieldset class="mb-3">

                    <legend>{{$meta_column['label']}}</legend>

                    <div class="input-group mb-3">
                        <label class="input-group-text" for="form_filter_{{$column}}">
                            {{$meta_column['label']}}
                        </label>
                        <input type="text" class="form-control" aria-label="" id="form_filter_{{$column}}" name="filter[{{$column}}][]" value="">
                    </div>

                    @foreach ($filter_ids_values as $id_index => $id)

                    @continue(empty($id))

                    @php
                    $id_label = $paginator->getCollection()->filter( function($item) use ($id, $column) {
                            return $item[$column] === $id;
                    })->pluck('label')->first();
                    @endphp


                    @if ('array' === $filter_ids_value_type)

                    <input type="hidden" name="filter[{{$column}}][]" value="{{$id}}">
                    <a href="{{request()->fullUrlWithoutQuery(sprintf('filter.%s.%s', $column, $id_index))}}"  class="btn btn-outline-warning">
                        {{$id_label ?? $id}}
                        <span class="fas fa-close"></span>
                    </a>

                    @else

                    <input type="hidden" name="filter[{{$column}}]" value="{{$id}}">
                    <a href="{{request()->fullUrlWithoutQuery(sprintf('filter.%s', $column))}}"  class="btn btn-outline-warning">
                        {{$id_label ?? $id}}
                        <span class="fas fa-close"></span>
                    </a>

                    @endif


                    @endforeach

                </fieldset>

            </div>

        @endforeach

    </div>

</fieldset>
