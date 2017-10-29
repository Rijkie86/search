<?php
namespace Admin\Form\Category\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Form\Category\CategoryForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class CategoryFormFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = new CategoryForm();
        $form->setHydrator(new DoctrineObject($container->get('Doctrine\ORM\EntityManager')));

        return $form;
    }
}