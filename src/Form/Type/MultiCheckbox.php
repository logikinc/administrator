<?php

namespace Terranet\Administrator\Form\Type;

use Form;

class MultiCheckbox extends Radio
{
    protected $attributes = [];

    protected $style = [
        'display' => 'inline-block',
        'min-width' => '200px',
    ];

    public function getFormName()
    {
        return parent::getFormName() . '[]';
    }

    /**
     * @param $name
     * @param $value
     * @param $attributes
     * @return mixed
     */
    protected function htmlInput($name, $value, $attributes)
    {
        return Form::checkbox($name, $value, in_array($value, (array) $this->value), $attributes);
    }
}
