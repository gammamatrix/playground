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
 * \GammaMatrix\Playground\View\Components\ModelFlag
 *
 */
class ModelFlag extends Component
{
    public function __construct(
        public array $columnMeta = [],
        public mixed $value = null,
        // public string $id = 'table-component',
        // public string $icon = '',
        // public string $badge = 'badge badge-pill badge-success',
        // public bool $showPagination = true,
        // public bool $showLinks = true,
        // public bool $modelActions = false,
        // public bool $trashable = true,
        // public string $routeEdit = '',
        // public string $routeRestore = '',
        // public string $routeDelete = '',
        // public string $routeDeleteRelationship = '',
        // public string $routeDeleteRelationshipId = '',
        // public bool $collapsible = true,
        // public string $returnUrl = '',
        // public ?array $filters = null,
        // public ?array $validated = null,
        // public ?array $sort = null,
        // public ?array $styling = null,
        // public string $class = '',
    ) {
    }

    public function render(): View
    {
        return view('playground::components.model-flag');
    }
}
