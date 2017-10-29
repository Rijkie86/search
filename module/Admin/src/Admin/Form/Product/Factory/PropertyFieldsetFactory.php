<?php
namespace Admin\Form\Product\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Admin\Form\Product\PropertyFieldset;

class PropertyFieldsetFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = new PropertyFieldset();
        $form->setHydrator(new DoctrineObject($container->get('Doctrine\ORM\EntityManager')))->setObject(new \Application\Entity\Property);
        
        return $form;
    }
}