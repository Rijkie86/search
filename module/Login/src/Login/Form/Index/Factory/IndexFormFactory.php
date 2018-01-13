<?php
namespace Login\Form\Index\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Login\Form\Index\IndexForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class IndexFormFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = new IndexForm();
        $form->setHydrator(new DoctrineObject($container->get('Doctrine\ORM\EntityManager')));

        return $form;
    }
}