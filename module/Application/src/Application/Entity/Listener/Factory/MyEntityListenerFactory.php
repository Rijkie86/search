<?php
namespace Application\Entity\Listener\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Entity\MyEntityListener;

class MyEntityListenerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('brandService');

        die('Erik');
        
        return new MyEntityListener($entityManager);
    }
}