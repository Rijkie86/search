<?php
namespace Admin\Filter\Product;

use Zend\Form\Form;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFilter extends Form implements ObjectManagerAwareInterface
{

    public function init()
    {
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'feed',
            'attributes' => [
                'class' => 'form-control input-xs'
            ],
            'options' => [
                'empty_option' => 'Maak uw keuze',
                'object_manager' => $this->getObjectManager(),
                'target_class' => 'Application\Entity\Feed',
                'property' => 'programId'
            ]
        ]);
    }

    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        
        return $this;
    }

    public function getObjectManager()
    {
        return $this->objectManager;
    }
}