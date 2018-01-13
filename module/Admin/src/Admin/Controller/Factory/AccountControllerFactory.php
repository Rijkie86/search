<?php
namespace Admin\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Controller\AccountController;

class AccountControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $formElementManager = $container->get('FormElementManager');
        
        $accountService = $container->get('accountService');
        
        return new AccountController($formElementManager, $accountService);
    }
}
