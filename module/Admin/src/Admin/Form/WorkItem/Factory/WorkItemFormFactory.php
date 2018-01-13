<?php
namespace Admin\Form\WorkItem\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Form\WorkItem\WorkItemForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class WorkItemFormFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = new WorkItemForm();
        $form->setHydrator(new DoctrineObject($container->get('Doctrine\ORM\EntityManager')));
        
        return $form;
    }
}