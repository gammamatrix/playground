<fieldset class="mb-3" id="{{$id}}-fieldset-filter-dates">

    <legend>
        <div class="float-end">
            <button type="submit" class="btn btn-success me-2">
                <i class="fa-solid fa-filter"></i>
                <span class="d-none d-sm-inline">Go</span>
            </button>
            <button class="btn btn-warning btn-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#{{$id}}-fieldset-filter-dates .container" aria-expanded="true" aria-controls="{{$id}}-fieldset-filter-dates .container">
                <i class="fa-solid fa-eye-slash"></i>
                <i class="fa-solid fa-calendar-days"></i>
            </button>
        </div>
        Filter Dates
    </legend>

    <div class="container collapse show">
        <div class="row">

            @foreach ($meta['dates'] as $column => $meta_column)

            @php $hasValidated = !empty($validated['filter']) && !empty($validated['filter'][$column]); @endphp

            <div class="col-12 col-md-6 col-lg-4">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="form_filter_{{$column}}">
                        {{$meta_column['label']}}
                    </label>
                    <input type="text" class="form-control" aria-label="" id="form_filter_{{$column}}" name="filter[{{$column}}]" value="{{$hasValidated ? $validated['filter'][$column] : ''}}">
                </div>
            </div>

            @endforeach

        </div>
    </div>

</fieldset>
