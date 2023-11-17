<div class="mb-3" style="background: teal">
    @if ($showLinks)
    <div class="float-end">
        {{$paginator->links('playground::pagination/bootstrap')}}
        {{-- {{$paginator->links('playground::pagination/bootstrap-simple')}} --}}
    </div>
    @endif
</div>
