<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\View\Components;

use Illuminate\View\Component;

/**
 * \GammaMatrix\Playground\View\Components\Modal
 *
 */
class Modal extends Component
{
    /**
     * @var string $id The model CSS identifier.
     */
    public $id = '';

    /**
     * @var string $bc Button class: btn-primary btn-success
     */
    public $bc = '';

    /**
     * @var boolean $withClose Show the close button.
     */
    public $wc = true;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $id,
        $bc,
        $wc = ''
    ) {
        $this->id = is_string($id) ? $id : '';
        $this->bc = is_string($bc) ? $bc : '';
        $this->wc = is_bool($wc) ? $wc : true;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view(sprintf(
            '%1$scomponents.modal',
            config('playground.view')
        ));
    }
}
