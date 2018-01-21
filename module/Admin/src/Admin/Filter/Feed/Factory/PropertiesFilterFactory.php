<?php
namespace Admin\Filter\Feed\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Filter\Feed\PropertiesFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class PropertiesFilterFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('Doctrine\ORM\EntityManager');
        
        $filter = new PropertiesFilter();
        $filter->setHydrator(new DoctrineObject($entityManager))
            ->setObjectManager($entityManager)
            ->setAttributes([
            'id' => 'filter'
        ]);
        
        return $filter;
    }
}