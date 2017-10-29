<?php
namespace Admin\Form\Bolt\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Admin\Form\Bolt\BoltSizeFieldset;
use Application\Entity\BoltSize;

class BoltSizeFieldsetFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $hydrator = new DoctrineObject($container->get('Doctrine\ORM\EntityManager'));
//         $hydrator->addStrategy('boltSize', new Strategy\DisallowRemoveByValue());
        
        $form = new BoltSizeFieldset();
        $form->setHydrator($hydrator)->setObject(new BoltSize());
        
        return $form;
    }
}