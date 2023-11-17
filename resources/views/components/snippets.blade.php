<?php
// dump([
//     '__METHOD__' => __METHOD__,
//     '__FILE__' => __FILE__,
//     '__LINE__' => __LINE__,
//     '$snippets' => $snippets,
// ]);
?>
@foreach ($snippets as $snippet)
@continue(empty($snippet['title']) && empty($snippet['content']))
<?php
if (empty($snippet['rank'])) {
    $stack = 'snippet-main';
} elseif ($snippet['rank'] < 0) {
    $stack = 'snippet-header';
} elseif (100 === $snippet['rank']) {
    $stack = 'snippet-content';
} elseif (200 === $snippet['rank']) {
    $stack = 'snippet-footer';
} else {
    $stack = 'snippet-content';
}
$containerClass = isset($snippet['meta']['container'])
    && isset($snippet['meta']['container']['class'])
    && is_string($snippet['meta']['container']['class'])
    ? $snippet['meta']['container']['class']
    : 'container-fluid'
;
$h = isset($snippet['meta']['header'])
    && isset($snippet['meta']['header']['level'])
    && is_numeric($snippet['meta']['header']['level'])
    && in_array((integer) $snippet['meta']['header']['level'], [1, 2, 3, 4, 5, 6])
    ? (integer) $snippet['meta']['header']['level']
    : 3
;
?>
@push($stack)
<div class="{{$containerClass}}">

    <div class="snippet">

@if (!empty($snippet['title']))
        <?= sprintf('<h%d>', $h) ?>{{$snippet['title']}}<?= sprintf('</h%d>', $h) ?>
@endif

@if (!empty($snippet['content']))
        <div class="snippet-content">

{!! $snippet['content'] !!}

        </div>
@endif

    </div>

</div>
@endpush
@endforeach
