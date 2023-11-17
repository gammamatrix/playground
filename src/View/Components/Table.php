<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * \GammaMatrix\Playground\View\Components\Table
 *
 */
class Table extends Component
{
    public function __construct(
        public string $id = 'table-component',
        public string $icon = '',
        public string $badge = 'badge badge-pill badge-success',
        public bool $showPagination = true,
        public bool $showLinks = true,
        public bool $modelActions = false,
        public bool $trashable = true,
        public string $routeParameter = 'id',
        public string $routeParameterKey = 'id',
        public string $routeEdit = '',
        public string $routeRestore = '',
        public string $routeDelete = '',
        public string $routeDeleteRelationship = '',
        public string $routeDeleteRelationshipId = '',
        public bool $collapsible = true,
        public string $returnUrl = '',
        public array $columns = [],
        public array $filters = [],
        public array $validated = [],
        public array $sort = [],
        public array $styling = [],
        public string $class = '',
        public ?LengthAwarePaginator $paginator = null,
    ) {
    }

    public function render(): View
    {
        return view('playground::components.table');
    }
}
