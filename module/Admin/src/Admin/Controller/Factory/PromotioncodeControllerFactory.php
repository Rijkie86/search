<?php
namespace Admin\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Controller\PromotioncodeController;

class PromotioncodeControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $formElementManager = $container->get('FormElementManager');

        return new PromotioncodeController($formElementManager);
    }
}
