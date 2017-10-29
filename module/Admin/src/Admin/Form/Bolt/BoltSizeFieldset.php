<?php
namespace Admin\Form\Bolt;

use Zend\Form\Fieldset;

class BoltSizeFieldset extends Fieldset
{
    public function init()
    {
        $this->add([
            'name' => 'metric',
            'type' => 'text',
            'attributes' => [
                'id' => 'test',
                'class' => 'form-control input-xs',
                'placeholder' => 'Metric'
            ],
            'options' => [
                'label' => 'Metric'
            ]
        ]);
        
        $this->add([
            'name' => 'steelLength',
            'type' => 'text',
            'attributes' => [
                'id' => 'test2',
                'class' => 'form-control input-xs',
                'placeholder' => 'Steel length'
            ],
            'options' => [
                'label' => 'Steel length'
            ]
        ]);
        
        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'quality',
            'attributes' => [
                'required' => 'required',
                'id' => 'test3',
                'class' => 'form-control input-xs',
                'placeholder' => 'Quality'
            ],
            'options' => [
                'label' => 'Quality'
            ]
        ]);
    }
}