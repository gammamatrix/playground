<?php
/**
 * Playground
 *
 * The table component.
 *
 * @component components/table
 */

$currentAccessToken = false;
$user = Auth::user();
if ($user && class_implements($user, \Laravel\Sanctum\Contracts\HasApiTokens::class)) {
    $currentAccessToken = $user->currentAccessToken();
}

/**
 * @var array $columns The columns in the table, keyed by slug.
 */
$columns = isset($columns) && is_array($columns) ? $columns : [];

if (empty($paginator) || empty($columns)) {
    // Only render this component if a paginator instance has been provided with columns.
    return;
}

$perPage = $paginator->perPage();

// $id = empty($id) ? 'table-component' : $id;
// // $icon = 'fa fa-ticket';
// $icon = '';
// $badge = 'badge badge-pill badge-success';
// $showPagination = isset($showPagination) ? (boolean) $showPagination : true;
// $showLinks = isset($showLinks) ? (boolean) $showLinks : true;
// $modelActions = isset($modelActions) ? (boolean) $modelActions : false;
// $trashable = isset($trashable) ? (boolean) $trashable : false;
// $routeEdit = isset($routeEdit) ? (string) $routeEdit : '';
// $routeRestore = isset($routeRestore) ? (string) $routeRestore : '';
// $routeDelete = isset($routeDelete) ? (string) $routeDelete : '';
// $routeDeleteRelationship = isset($routeDeleteRelationship) ? (string) $routeDeleteRelationship : '';
// $routeDeleteRelationshipId = isset($routeDeleteRelationshipId) ? (string) $routeDeleteRelationshipId : '';
// $collapsible = isset($collapsible) ? (boolean) $collapsible : false;
$returnUrl = empty($returnUrl) ? url()->full() : $returnUrl;
// $filters = isset($filters) ? $filters : null;
// $validated = isset($validated) ? $validated : null;
// $input = isset($input) ? $input : null;
// $sort = isset($sort) ? $sort : null;
// $showForm = !empty($filters) || !empty($input) || !empty($sort) || !empty($validated);
$showForm = true;
// dump([
//     '__METHOD__' => __METHOD__,
//     '__FILE__' => __FILE__,
//     '__LINE__' => __LINE__,
//     // '$this' => $this,
//     '$paginator' => $paginator,
//     '$columns' => $columns,
// ]);

$styling = isset($styling) && is_array($styling) ? $styling : [];
$hasHeaderStyling = isset($styling['header']) && is_array($styling['header']) && !empty($styling['header']);
$headerClass = '';

// dd([
//     '__METHOD__' => __METHOD__,
//     '__FILE__' => __FILE__,
//     '__LINE__' => __LINE__,
//     '$meta' => $meta,
//     '$columns' => $columns,
//     '$styling' => $styling,
//     '$showPagination' => $showPagination,
//     '$filters' => $filters,
//     // '$paginator' => $paginator->toArray(),
//     '$paginator' => $paginator,
//     // '$hasHeaderStyling' => $hasHeaderStyling,
// ]);

################################################################################
#
# Header
#
################################################################################

//  Header badge
if ($hasHeaderStyling && isset($styling['header']['badge']) && is_string($styling['header']['badge'])) {
    $badge = $styling['header']['badge'];
} else {
    $badge = 'badge bg-success';
}

//  Header class
if ($hasHeaderStyling && isset($styling['header']['class']) && is_string($styling['header']['class'])) {
    $headerClass = $styling['header']['class'];
}
?>
<div class="panel {{ $headerClass }}" id="{{ $id }}">

    <div class="table-responsive">

        @include('playground::components/table/data-form')

        <table class="table">

            <thead>
                <tr>
                    @foreach ($columns as $column => $columnMeta)
                        <th class="{{ !empty($columnMeta['hide-sm']) ? 'd-none d-sm-table-cell' : '' }}">
                            @if (isset($columnMeta['icon']))
                                <span class="{{ $columnMeta['icon'] }}"></span>
                            @endif
                            @if (isset($columnMeta['label']))
                                {{ $columnMeta['label'] }}
                            @endif
                        </th>
                    @endforeach
                    @if ($modelActions)
                        <th>
                            Actions
                        </th>
                    @endif
                </tr>
            </thead>

            @if ($showLinks && $paginator->count() > 10)
                <tfoot>
                    <tr>
                        <td colspan="{{ $modelActions ? count($columns) + 1 : count($columns) }}">
                            <h2 class="h4">
                                @if ($icon)
                                    <span class="{{ $icon }}"></span>
                                @endif
                                {{ $slot }}
                                <span class="{{ $badge }}">{{ $paginator->count() }} </span>

                                <div class="float-end">
                                    {{ $paginator->links() }}
                                </div>
                            </h2>
                        </td>
                    </tr>
                </tfoot>
            @endif

            <tbody>
                @foreach ($paginator as $datum)
                    @php $record = $datum->toArray(); @endphp
                    <tr>
                        @include('playground::components/table/data-row')
                        @includeWhen($modelActions, 'playground::components/table/data-row-actions')
                    </tr>
                @endforeach
            </tbody>

        </table>

        @include('playground::components/table/data-footer')

    </div>

</div>
