<fieldset class="mb-3" id="{{$id}}-fieldset-filter-model">

    <legend>
        <div class="float-end">
            <button type="submit" class="btn btn-success me-2">
                <i class="fa-solid fa-filter"></i>
                <span class="d-none d-sm-inline">Go</span>
            </button>
            <button class="btn btn-warning btn-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#{{$id}}-fieldset-filter-model .container" aria-expanded="true" aria-controls="{{$id}}-fieldset-filter-model .container">
                <i class="fa-solid fa-eye-slash"></i>
                <i class="fa-solid fa-list"></i>
            </button>
        </div>
        Filter Model
    </legend>

    <div class="container collapse show">
        <div class="row">

            @foreach ($meta['model'] as $column => $meta_column)

            @php
            $hasValidated = !empty($validated['filter']) && !empty($validated['filter'][$column]);
            $type = !empty($meta_column['type'])
                && in_array($meta_column['type'], [
                    'boolean',
                    'string',
                    'uuid',
                ]) ? $meta_column['type'] : ''
            ;
            @endphp

            @if ('boolean' === $type)

            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="input-group mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" aria-label="" id="form_filter_{{$column}}" name="filter[{{$column}}]" value="1" {{$hasValidated ? 'checked' : ''}}>
                        <label class="form-check-label" for="form_filter_{{$column}}">
                            {{$meta_column['label']}}
                        </label>
                    </div>
                </div>
            </div>

            @else

            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="form_filter_{{$column}}">
                        {{$meta_column['label']}}
                    </label>
                    <input type="text" class="form-control" aria-label="" id="form_filter_{{$column}}" name="filter[{{$column}}]" value="{{$hasValidated ? $validated['filter'][$column] : ''}}">
                </div>
            </div>

            @endif

            @endforeach

        </div>
    </div>

</fieldset>
