<?php
namespace Admin\Form\Feed;

use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class LinkForm extends Form implements InputFilterProviderInterface
{

    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
        
        parent::__construct();
    }

    public function init()
    {
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'listObject',
            'attributes' => [
                'id' => 'listObject',
                'class' => 'form-control input-sm',
                'placeholder' => 'Table'
            ],
            'options' => [
                'object_manager' => $this->entityManager,
                'target_class' => 'Application\Entity\ListObject',
                'property' => 'name',
                'empty_option' => ''
            ]
        ]);
        
        $this->add([
            'type' => 'Zend\Form\Element\Select',
            'name' => 'dbTableProperty',
            'attributes' => [
                'id' => 'dbTableProperty',
                'class' => 'form-control input-sm',
                'placeholder' => 'Property',
            ],
            'options' => [
                'empty_option' => '',
                'disable_inarray_validator' => true
            ]
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            'listObject' => [
                'required' => true
            ],
            'dbTableProperty' => [
                'required' => true
            ]
        ];
    }
}