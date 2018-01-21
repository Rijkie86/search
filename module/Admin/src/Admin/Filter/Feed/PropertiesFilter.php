<?php
namespace Admin\Filter\Feed;

use Zend\Form\Form;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PropertiesFilter extends Form implements ObjectManagerAwareInterface
{

    public function init()
    {
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'listFeedPropertyStatus',
            'attributes' => [
                'class' => 'form-control input-xs'
            ],
            'options' => [
                'empty_option' => 'Maak uw keuze',
                'object_manager' => $this->getObjectManager(),
                'target_class' => 'Application\Entity\ListFeedPropertyStatus',
                'property' => 'name'
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