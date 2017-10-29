<?php
namespace Admin\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Controller\CategoryController;

class CategoryControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $categoryService = $container->get('categoryService');
        $feedCategoryValueService = $container->get('feedCategoryValueService');
        
        $formElementManager = $container->get('FormElementManager');
        
        return new CategoryController($categoryService, $formElementManager, $feedCategoryValueService);
    }
}
