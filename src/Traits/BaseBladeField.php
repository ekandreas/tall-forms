<?php

namespace Tanthammar\TallForms\Traits;

use Illuminate\View\Component;
use Tanthammar\TallForms\Helpers;

abstract class BaseBladeField extends Component
{
    protected array $baseField = [
        'id' => '',
        'name' => '',
        'key' => '',
        'class' => '',
        'wire' => 'wire:model',
        'defer' => false,  //set in BaseField __construct to config()
        'deferString' => null, //keep null, if defer = true, deferString will be filled in BaseField __construct
        'appendClass' => null,
        'errorClass' => '',
        'appendErrorClass' => 'tf-field-error',
    ];

    abstract protected function defaults(): array;

    public function __construct(public array|object $field = [], public array $attr = [])
    {
        //merge, base, defaults, custom to Object
        $this->field = Helpers::mergeFilledToObject(array_merge($this->baseField, $this->defaults()), $field);
        $this->field->class = $this->class();
        $this->field->errorClass = $this->error();
        $this->attr = array_merge(data_get($field, 'attributes.input', []), $attr);

        //Check if field rules contains 'required', not used by all fields
        if (isset($this->field->required) && !$this->field->required) {
            $this->field->required = is_array($this->field->rules)
                ? in_array('required', $this->field->rules)
                : str_contains($this->field->rules, 'required');
        }
    }

    protected function class(): string
    {
        return $this->field->appendClass
            ? Helpers::unique_words("{$this->field->class} {$this->field->appendClass}")
            : $this->field->class;
    }

    protected function error(): string
    {
        return $this->field->appendErrorClass
            ? Helpers::unique_words("{$this->field->class} {$this->field->appendErrorClass}")
            : $this->field->errorClass;
    }

}
