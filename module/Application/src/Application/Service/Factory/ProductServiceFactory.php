<?php
namespace Application\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Service\ProductService;

class ProductServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('Doctrine\ORM\EntityManager');
        
        $authorize = $container->get('authorize');

        return new ProductService($entityManager, $container->get('propertyService'), $authorize);
    }
}