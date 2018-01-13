<?php
namespace Admin\Form\Product;

use Zend\Form\Form;
use Application\Entity\Product;

class ProductForm extends Form
{
    public function init()
    {
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'placeholder' => 'Naam'
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'description',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'placeholder' => 'Description'
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'url',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'placeholder' => 'Url'
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Number',
            'name' => 'price',
            'attributes' => array(
                'class' => 'form-control input-sm',
                'placeholder' => 'Price'
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'accommodation',
            'options' => array(
                'label' => 'Accommodation',
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => 'accommodationFieldset'
                )
            )
        ));
    }
}