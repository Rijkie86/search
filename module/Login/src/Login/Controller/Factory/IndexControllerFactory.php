<?php
namespace Login\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Login\Controller\IndexController;

class IndexControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authenticationService = $container->get('doctrine.authenticationservice.orm_default');
        
        $formElementManager = $container->get('FormElementManager');

        return new IndexController($authenticationService, $formElementManager);
    }
}