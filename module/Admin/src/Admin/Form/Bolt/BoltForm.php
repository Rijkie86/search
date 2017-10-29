<?php
namespace Admin\Form\Bolt;

use Zend\Form\Form;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;

class BoltForm extends Form implements ObjectManagerAwareInterface
{

    private $objectManager;

    public function init()
    {
        // $this->add([
        // 'name' => 'boltSizeFieldset',
        // 'type' => 'BoltSizeFieldset'
        // ]);

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'boltSize',
            'options' => array(
                'label' => 'Please add different sizes for this product',
                'count' => 1,
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => 'boltSizeFieldset'
                )
            )
        ));

        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name',
            'attributes' => [
                'required' => 'required',
                'id' => 'name',
                'class' => 'form-control input-sm',
                'placeholder' => 'Name'
            ]
        ]);
        
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'din',
            'attributes' => [
                'required' => 'required',
                'class' => 'form-control select'
            ],
            'options' => [
                'empty_option' => 'Maak uw keuze',
                'object_manager' => $this->getObjectManager(),
                'target_class' => 'Application\Entity\Din',
                'property' => 'name'
            ]
        ]);
    }

    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function getObjectManager()
    {
        return $this->objectManager;
    }
}