<?php

namespace Terranet\Administrator\Form\Collection;

use Closure;
use Terranet\Administrator\Collection\Mutable as BaseMutableCollection;
use Terranet\Administrator\Exception;
use Terranet\Administrator\Form\FilterElement;
use Terranet\Administrator\Form\FormElement;
use Terranet\Administrator\Form\InputFactory;
use Terranet\Administrator\Form\Type\Ckeditor;
use Terranet\Administrator\Form\Type\Tinymce;

class Mutable extends BaseMutableCollection
{
    /**
     * Insert a new form element.
     *
     * @param $element
     * @param mixed string|Closure $inputType
     * @param mixed null|int|string $position
     * @return $this
     * @throws Exception
     */
    public function create($element, $inputType = null, $position = null)
    {
        if (!(is_string($element) || $element instanceof FormElement)) {
            throw new Exception("\$element must be string or FormElement instance.");
        }

        # Create new element from string declaration ("title").
        if (is_string($element)) {
            $element = (new FormElement($element));
        }

        # Create Form Input Element from string declaration ("textarea")
        if (is_string($inputType)) {
            $oldInput = $element->getInput();
            $newInput = InputFactory::make($element->id(), $inputType);

            $newInput->setRelation(
                $oldInput->getRelation()
            )->setTranslatable(
                $oldInput->getTranslatable()
            );

            $element->setInput(
                $newInput
            );
        }

        # Allow a callable input type.
        if (is_callable($inputType)) {
            call_user_func_array($inputType, [  $element]);
        }

        if (is_numeric($position)) {
            return $this->insert($element, $position);
        }

        # Push element
        $this->push($element);

        if (null !== $position) {
            return $this->move($element->id(), $position);
        }

        return $this;
    }

    public function hasEditors($editor)
    {
        $this->validateEditor($editor);

        return !!$this->filter(function (FormElement $element) use ($editor) {
            $input = $element->getInput();

            if ('ckeditor' == $editor) {
                return $input instanceof Ckeditor;
            }

            return $input instanceof Tinymce;
        })->count();
    }

    /**
     * @param $editor
     * @throws Exception
     */
    protected function validateEditor($editor)
    {
        if (!in_array($editor, ['ckeditor', 'tinymce'])) {
            throw new Exception(sprintf("Unknown editor %s", $editor));
        }
    }
}