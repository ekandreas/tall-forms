<?php


namespace Tanthammar\TallForms\Components;

use Illuminate\View\View;
use Tanthammar\TallForms\Traits\BaseBladeField;

class Trix extends BaseBladeField
{
    public function __construct(
        public array|object $field = [],
        public array        $attr = [])
    {
        parent::__construct((array)$field, $attr);
    }


    protected function defaults(): array
    {
        return [
            'id' => 'trix',
            'class' => 'form-textarea w-full shadow-inner',
            'includeScript' => true,
            //sponsor field defaults;
            'allowAttachments' => false,
            'attachmentKey' => '',
            'allowedMimeTypes' => [],
            'maxAttachments' => 1,
            'maxKB' => 1024,
            'disabled' => false,
        ];
    }

    public function render(): View
    {
        if ($this->field->allowAttachments) return view('tall-forms-sponsors::components.trix-with-attachments');
        return view('tall-forms::components.trix');
    }
}
