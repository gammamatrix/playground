<form method="get" action="">

    <div class="px-2">

        <div class="col-md-12">

            <div class="data-form collapse hide">

                @include('playground::components/table/data-form-filter')

                @include('playground::components/table/data-form-pagination')

                @include('playground::components/table/data-form-sort')

            </div>

        </div>

        <h2 class="h4">

            @if ($icon)
            <span class="{{ $icon }}"></span>
            @endif
            {{ $slot }}

            <span class="{{ $badge }}">{{ $paginator->count() }} </span>

            <div class="ms-2 float-end">
                <button class="btn btn-warning btn-toggler text-nowrap py-1" type="button" data-bs-toggle="collapse" data-bs-target="#{{$id}} div.data-form" aria-expanded="true" aria-controls="{{$id}} div.data-form">
                    <i class="fa-solid fa-filter"></i>
                    <span class="d-none d-sm-inline">Filters</span>
                </button>
            </div>
            <div class="float-end">
                    {{$paginator->links('playground::pagination/bootstrap-simple')}}
            </div>
        </h2>
    </div>

</form>
