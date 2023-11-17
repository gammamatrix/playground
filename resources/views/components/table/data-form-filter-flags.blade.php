<fieldset class="mb-3" id="{{$id}}-fieldset-filter-flags">

    <legend>
        <div class="float-end">
            <button type="submit" class="btn btn-success me-2">
                <i class="fa-solid fa-filter"></i>
                <span class="d-none d-sm-inline">Go</span>
            </button>
            <button class="btn btn-warning btn-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#{{$id}}-fieldset-filter-flags .container" aria-expanded="true" aria-controls="{{$id}}-fieldset-filter-flags .container">
                <i class="fa-solid fa-eye-slash"></i>
                <i class="fa-solid fa-flag"></i>
            </button>
        </div>
        Filter Flags
    </legend>

    <div class="container collapse show">
        <div class="row">

            @foreach ($meta['flags'] as $column => $meta_column)

            @php $hasValidated = !empty($validated['filter']) && !empty($validated['filter'][$column]); @endphp

            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="input-group mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" aria-label="" id="form_filter_{{$column}}" name="filter[{{$column}}]" value="1" {{$hasValidated ? 'checked' : ''}}>
                        <label class="form-check-label" for="form_filter_{{$column}}">
                            @if (!empty($meta_column['icon']) && is_string($meta_column['icon']))
                            <i class="{{$meta_column['icon']}}"></i>
                            @endif
                            {{$meta_column['label']}}
                        </label>
                    </div>
                </div>
            </div>

            @endforeach

        </div>
    </div>

</fieldset>
