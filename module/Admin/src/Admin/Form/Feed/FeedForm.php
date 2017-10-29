<?php
namespace Admin\Form\Feed;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class FeedForm extends Form implements InputFilterProviderInterface
{

    public function init()
    {
        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'file',
            'attributes' => [
                'class' => 'form-control input-sm',
                'placeholder' => 'Url'
            ]
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'file' => [
                'required' => true
            ]
        ];
    }
}