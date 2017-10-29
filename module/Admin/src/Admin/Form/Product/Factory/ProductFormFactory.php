<?php
namespace Admin\Form\Product\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Form\Product\ProductForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class ProductFormFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = new ProductForm();
        $form->setHydrator(new DoctrineObject($container->get('Doctrine\ORM\EntityManager')));
        
        return $form;
    }
}