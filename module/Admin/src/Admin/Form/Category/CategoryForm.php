<?php
namespace Admin\Form\Category;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class CategoryForm extends Form implements InputFilterProviderInterface
{

    public function init()
    {
        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name',
            'attributes' => [
                'class' => 'form-control input-sm',
                'placeholder' => 'Category naam'
            ]
        ]);
        
        $this->add([
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'description',
            'attributes' => [
                'id' => 'description',
                'class' => 'form-control input-sm',
                'placeholder' => 'Omschrijving'
            ]
        ]);
        
        $this->add([
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'parent'
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'name' => [
                'required' => true
            ],
            'parent' => [
                'required' => false
            ]
        ];
    }
}