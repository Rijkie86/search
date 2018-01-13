<?php
namespace Admin\Form\Account;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class AccountForm extends Form implements InputFilterProviderInterface
{

    public function init()
    {
        $this->add([
            'type' => 'Zend\Form\Element\Email',
            'name' => 'email',
            'attributes' => [
                'class' => 'form-control input-sm',
                'placeholder' => 'E-mail address'
            ]
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'email' => [
                'required' => true
            ]
        ];
    }
}