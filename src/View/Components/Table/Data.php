<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\View\Components\Table;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * \GammaMatrix\Playground\View\Components\Table\Data
 *
 */
class Data extends Component
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
        public array $meta = [],
        public array $sort = [],
        public array $page_options = [
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            15,
            20,
            25,
            30,
            35,
            50,
            100,
        ],
        public int $sorts = 3,
        public array $styling = [],
        public string $class = '',
        public ?LengthAwarePaginator $paginator = null,
    ) {
    }

    public function render(): View
    {
        return view('playground::components.table.data');
    }
}
