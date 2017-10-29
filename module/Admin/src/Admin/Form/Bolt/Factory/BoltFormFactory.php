<?php
namespace Admin\Form\Bolt\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Form\Bolt\BoltForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Application\Entity\Bolt;
use DoctrineModule\Stdlib\Hydrator\Strategy;

class BoltFormFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $hydrator = new DoctrineObject($container->get('Doctrine\ORM\EntityManager'));
//         $hydrator->addStrategy('boltSize', new Strategy\DisallowRemoveByValue());
        
        $form = new BoltForm();
        $form->setHydrator($hydrator)->setObject(new Bolt());
        
        return $form;
    }
}