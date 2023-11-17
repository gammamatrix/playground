<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\View\Components;

use Illuminate\View\Component;

/**
 * \GammaMatrix\Playground\View\Components\Snippets
 *
 */
class Snippets extends Component
{
    public $snippets = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($snippets)
    {
        $this->snippets = is_array($snippets) ? $snippets : [];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view(sprintf(
            '%1$scomponents.snippets',
            config('playground.view')
        ), [
            'snippets' => $this->snippets,
        ]);
    }
}
