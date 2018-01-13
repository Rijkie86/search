<?php
namespace Admin\Form\ComparisonTool\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Form\ComparisonTool\ComparisonToolForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class ComparisonToolFormFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = new ComparisonToolForm();
        $form->setHydrator(new DoctrineObject($container->get('Doctrine\ORM\EntityManager')));

        return $form;
    }
}