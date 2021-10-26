<?php


namespace Tanthammar\TallForms\Components;

use Illuminate\View\View;
use Tanthammar\TallForms\Traits\BaseBladeField;

class Radio extends BaseBladeField
{
    public function __construct(
        public array|object $field = [],
        public array        $attr = [],
    )
    {
        parent::__construct((array)$field, $attr);
    }

    protected function defaults(): array
    {
        return [
            'id' => 'radio', //unique, concats id.value.loop-index on each radio input,
            'radioClass' => "form-radio tf-radio",
            'radioLabelClass' => "tf-radio-label",
            'spacing' => "tf-radio-label-spacing",
            'class' => 'flex', //input & label wrapper
            'wrapperClass' => 'tf-radio-fieldset', //fieldset
            'options' => [],
            'disabled' => false,
        ];
    }

    public function render(): View
    {
        return view('tall-forms::components.radio');
    }
}
