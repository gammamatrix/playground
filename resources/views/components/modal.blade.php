<button type="button" class="btn {{$bc}}" data-bs-toggle="modal" data-bs-target="#{{$id}}">
{{$button}}
</button>

@push('body')
<div class="modal fade" id="{{$id}}" tabindex="-1" aria-labelledby="{{sprintf('%s-label', $id)}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{sprintf('%s-label', $id)}}">{{$title}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
{!!$slot!!}
            </div>
            <div class="modal-footer">
<?php
// dump([
//     '__METHOD__' => __METHOD__,
//     '__FILE__' => __FILE__,
//     '__LINE__' => __LINE__,
//     '$id' => $id,
//     '$bc' => $bc,
//     '$wc' => $wc,
// ]);
?>

                @if (!empty($footer))
                {!!$footer!!}
                @endif
                @if (!empty($wc))
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                @endif
                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>
@endpush
