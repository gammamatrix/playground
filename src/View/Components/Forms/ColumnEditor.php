<?php
/**
 * Playground
 */
namespace Playground\View\Components\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * \Playground\View\Components\Forms\ColumnEditor
 */
class ColumnEditor extends Component
{
    public function __construct(
        public bool $advanced = false,
        public string $class = 'editor',
        public string $column = '',
        public string $errorMessage = '',
        public string $label = '',
        /**
         * @var array $rules
         * @var bool $rules[required] - Make the column required.
         * @var int $rules[maxlength] - Limit the number of characters in the content.
         */
        public array $rules = [],
        public bool $withoutMargin = false,
        public string $described = '',
        public ?bool $disabled = null,
        public ?bool $readonly = null,
    ) {
    }

    public function render(): View
    {
        return view('playground::components.forms.column-editor');
    }
}
