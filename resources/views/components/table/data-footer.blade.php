<div class="mb-3">
    @if ($showLinks)
    <div class="float-end">
        {{$paginator->links('playground::pagination/bootstrap')}}
        {{-- {{$paginator->links('playground::pagination/bootstrap-simple')}} --}}
    </div>
    @endif
</div>
