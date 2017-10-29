<?php
namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Controller\ConsoleController;

class ConsoleControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $feedService = $container->get('feedService');
        
        $categoryService = $container->get('categoryService');
        
        $productService = $container->get('productService');
        
        $entityManager = $container->get('Doctrine\ORM\EntityManager');

        return new ConsoleController($feedService, $categoryService, $productService, $entityManager);
    }
}