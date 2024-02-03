<?php
/**
 * Playground
 *
 */

namespace Playground\View\Components\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * \Playground\View\Components\Forms\ColumnSelect
 *
 */
class ColumnSelect extends Component
{
    public function __construct(
        public bool $advanced = false,
        public ?bool $autocomplete = null,
        public string $class = '',
        public string $column = '',
        public bool $default = true,
        public string $described = '',
        public ?bool $disabled = null,
        public string $errorMessage = '',
        public string $id = 'id',
        public string $key = 'label',
        public string $label = '',
        public string $pattern = '',
        public bool|string $placeholder = false,
        public array $records = [],
        /**
         * @var array $rules
         * @var bool $rules[required] - Make the column required.
         */
        public array $rules = [],
        public string $step = '',
        public ?bool $readonly = null,
        public string $type = '',
        public bool $withoutMargin = false,
    ) {
    }

    public function render(): View
    {
        return view('playground::components.forms.column-select');
    }
}
