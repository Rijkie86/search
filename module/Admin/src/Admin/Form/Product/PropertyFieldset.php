<?php
namespace Admin\Form\Product;

use Zend\Form\Fieldset;

class PropertyFieldset extends Fieldset
{

    public function init()
    {
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name',
            'attributes' => array(
                'class' => 'form-control input-sm'
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'value',
            'attributes' => array(
                'class' => 'form-control input-sm'
            )
        ));
    }
}