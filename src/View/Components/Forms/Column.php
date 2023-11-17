<?php
/**
 * GammaMatrix
 *
 */

namespace GammaMatrix\Playground\View\Components\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * \GammaMatrix\Playground\View\Components\Forms\Column
 *
 */
class Column extends Component
{
    public function __construct(
        public bool $advanced = false,
        public ?bool $autocomplete = null,
        public string $class = '',
        public string $column = '',
        public string $default = '',
        public string $described = '',
        public ?bool $disabled = null,
        public string $errorMessage = '',
        public string $label = '',
        public string $pattern = '',
        public bool|string $placeholder = false,
        public ?bool $readonly = null,
        /**
         * @var array $rules
         * @var bool $rules[required] - Make the column required.
         * @var int $rules[maxlength] - Limit the number of characters in the content.
         * @var ?int $rules[max] - Require a maximum value.
         * @var ?int $rules[min] - Require a minumum value.
         */
        public array $rules = [],
        public ?int $step = null,
        public string $type = 'text',
        public bool $withoutMargin = false,
    ) {
    }

    public function render(): View
    {
        return view('playground::components.forms.column');
    }
}
