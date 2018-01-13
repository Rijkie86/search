<?php
namespace Admin\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Controller\TodoController;

class TodoControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $formElementManager = $container->get('FormElementManager');
        
        $todoService = $container->get('todoService');
        
        return new TodoController($formElementManager, $todoService);
    }
}
