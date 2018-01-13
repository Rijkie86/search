<?php
namespace Admin\Form\Product;

use Zend\Form\Fieldset;

class AccommodationFieldset extends Fieldset
{

    public function init()
    {
        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name',
            'attributes' => [
                'class' => 'form-control input-sm'
            ]
        ]);
        
        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'latitude',
            'attributes' => [
                'class' => 'form-control input-sm'
            ]
        ]);
        
        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'longitude',
            'attributes' => [
                'class' => 'form-control input-sm'
            ]
        ]);
    }
}