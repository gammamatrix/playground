<?php
/**
 * Playground
 */
namespace Playground\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * \Playground\View\Components\ModelFlag
 */
class ModelFlag extends Component
{
    public function __construct(
        public array $columnMeta = [],
        public mixed $value = null
    ) {
    }

    public function render(): View
    {
        return view('playground::components.model-flag');
    }
}
