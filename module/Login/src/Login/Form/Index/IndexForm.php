<?php
namespace Login\Form\Index;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class IndexForm extends Form implements InputFilterProviderInterface
{

    public function init()
    {
        $this->add([
            'type' => 'Zend\Form\Element\Email',
            'name' => 'email',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'E-mail address'
            ]
        ]);
        
        $this->add([
            'type' => 'Zend\Form\Element\Password',
            'name' => 'password',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Password'
            ]
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'email' => [
                'required' => true
            ],
            'password' => [
                'required' => true
            ]
        ];
    }
}