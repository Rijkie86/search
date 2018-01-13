<?php
namespace Admin\Form\Feed\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Form\Feed\LinkForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Application\Entity\FeedProductProperty;

class LinkFormFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = new LinkForm($container->get('Doctrine\ORM\EntityManager'));
        $form->setHydrator(new DoctrineObject($container->get('Doctrine\ORM\EntityManager')))
            ->setObject(new FeedProductProperty());
        
        return $form;
    }
}