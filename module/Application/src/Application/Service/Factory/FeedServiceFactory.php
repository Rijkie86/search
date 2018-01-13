<?php
namespace Application\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Service\FeedService;

class FeedServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $feedCategoryValueService = $container->get('feedCategoryValueService');
        
        $entityManager = $container->get('Doctrine\ORM\EntityManager');
        $authorize = $container->get('authorize');

        return new FeedService($feedCategoryValueService, $entityManager, $authorize);
    }
}