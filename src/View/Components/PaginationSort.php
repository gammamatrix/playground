<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\View\Components;

use Illuminate\View\Component;

/**
 * \GammaMatrix\Playground\View\Components\PaginationSort
 *
 * @see \App\Http\Requests\AbstractIndexRequest::SORT
 */
class PaginationSort extends Component
{
    /**
     * @var string the form action.
     */
    public $action = '';

    /**
     * @var string the form action.
     */
    public $id = '';

    /**
     * @var array The validated request data.
     */
    public $validated = [];

    /**
     * @var array The sortable columns.
     */
    public $sort = [];

    /**
     * @var integer The number of sortable columns.
     */
    public $sorts = 2;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $sort,
        $validated = [],
        $action = '',
        $id = '',
        $sorts = 3
    ) {
        $this->setSort($sort);
        $this->id = is_string($id) ? $id : '';
        $this->action = is_string($action) ? $action : '';
        $this->sorts = is_numeric($sorts) && $sorts <= 5 && $sorts ? (int) $sorts : 2;
        $this->validated = is_array($validated) ? $validated : [];
    }

    /**
     * Set the sort information.
     *
     * @param array $sort
     *
     * @return array
     */
    public function setSort($sort): array
    {
        if (empty($sort) || !is_array($sort)) {
            $this->sort = [];
        }

        foreach ($sort as $slug => $meta) {
            if (is_numeric($slug)) {
                // Ignore bad input.
                continue;
            }
            $this->sort[] = [
                'column' => $slug,
                'label' => empty($meta['label']) || !is_string($meta['label']) ? $slug : $meta['label'],
            ];
        }

        return $this->sort;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view(sprintf(
            '%1$scomponents.pagination.sort',
            config('playground.view')
        ));
    }
}
