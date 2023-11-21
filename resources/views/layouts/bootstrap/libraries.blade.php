@foreach ($required as $script)
@continue(empty($libs[$script]) || !is_array($libs[$script]))
@if (!empty($libs[$script]['type']) && $libs[$script]['type'] === 'link')
<?= sprintf(
    '<link%1$s%2$s%3$s%4$s>',
    empty($libs[$script]['href']) ? '' : sprintf(' href="%1$s"', $libs[$script]['href']),
    empty($libs[$script]['integrity']) ? '' : sprintf(' integrity="%1$s"', $libs[$script]['integrity']),
    empty($libs[$script]['crossorigin']) ? '' : sprintf(' crossorigin="%1$s"', $libs[$script]['crossorigin']),
    empty($libs[$script]['rel']) ? '' : sprintf(' rel="%1$s"', $libs[$script]['rel'])
) ?>

@elseif (!empty($libs[$script]['type']) && $libs[$script]['type'] === 'style')
<?= sprintf('<style>%1$s</style>', ($libs[$script]['style']) ?? '') ?>

@else
<?= sprintf(
    '<script%1$s%2$s%3$s%4$s></script>',
    empty($libs[$script]['src']) ? '' : sprintf(' src="%1$s"', $libs[$script]['src']),
    empty($libs[$script]['integrity']) ? '' : sprintf(' integrity="%1$s"', $libs[$script]['integrity']),
    empty($libs[$script]['crossorigin']) ? '' : sprintf(' crossorigin="%1$s"', $libs[$script]['crossorigin']),
    empty($libs[$script]['referrerpolicy']) ? '' : sprintf(' referrerpolicy="%1$s"', $libs[$script]['referrerpolicy'])
) ?>

@endif
@endforeach