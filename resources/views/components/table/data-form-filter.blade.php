<div>

    <div class="float-end">
        <button type="submit" class="btn btn-success me-2">
            <i class="fa-solid fa-filter"></i>
            <span class="d-none d-sm-inline">Go</span>
        </button>
        <button class="btn btn-warning btn-toggler text-nowrap py-1" type="button" data-bs-toggle="collapse" data-bs-target="#{{$id}} div.data-form" aria-expanded="true" aria-controls="{{$id}} div.data-form">
            <i class="fa-solid fa-eye-slash"></i>
            <i class="fa-solid fa-filter"></i>
            <span class="d-none d-sm-inline">Hide Filters</span>
        </button>
    </div>

@includeWhen($trashable, 'playground::components/table/data-form-filter-trash')

@includeWhen(!empty($meta['ids']), 'playground::components/table/data-form-filter-ids')

@includeWhen(!empty($meta['dates']), 'playground::components/table/data-form-filter-dates')

@includeWhen(!empty($meta['flags']), 'playground::components/table/data-form-filter-flags')

@includeWhen(!empty($meta['model']), 'playground::components/table/data-form-filter-model')

</div>
