<?php
namespace Admin\Filter\Product\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Filter\Product\ProductFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class ProductFilterFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('Doctrine\ORM\EntityManager');
        
        $filter = new ProductFilter();
        $filter->setHydrator(new DoctrineObject($entityManager))->setObjectManager($entityManager)->setAttributes(['id' => 'filter']);
        
        return $filter;
    }
}