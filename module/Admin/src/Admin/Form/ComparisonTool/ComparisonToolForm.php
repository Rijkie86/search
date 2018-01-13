<?php
namespace Admin\Form\ComparisonTool;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class ComparisonToolForm extends Form implements InputFilterProviderInterface
{

    public function init()
    {
        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name',
            'attributes' => [
                'class' => 'form-control input-sm',
                'placeholder' => 'Name'
            ]
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'name' => [
                'required' => true
            ]
        ];
    }
}