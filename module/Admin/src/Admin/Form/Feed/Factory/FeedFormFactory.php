<?php
namespace Admin\Form\Feed\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Form\Feed\FeedForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class FeedFormFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = new FeedForm();
        $form->setHydrator(new DoctrineObject($container->get('Doctrine\ORM\EntityManager')));

        return $form;
    }
}