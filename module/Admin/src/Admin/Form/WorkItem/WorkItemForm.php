<?php
namespace Admin\Form\WorkItem;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class WorkItemForm extends Form implements InputFilterProviderInterface
{

    public function init()
    {
        $this->add([
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'description',
            'attributes' => [
                'class' => 'form-control input-sm',
                'placeholder' => 'Description'
            ]
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'description' => [
                'required' => true
            ]
        ];
    }
}