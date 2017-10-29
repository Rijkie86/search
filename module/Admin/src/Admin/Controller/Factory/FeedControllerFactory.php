<?php
namespace Admin\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Controller\FeedController;

class FeedControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $feedService = $container->get('feedService');
        $formElementManager = $container->get('FormElementManager');
        
        return new FeedController($feedService, $formElementManager);
    }
}