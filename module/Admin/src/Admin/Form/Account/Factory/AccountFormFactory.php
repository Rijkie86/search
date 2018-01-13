<?php
namespace Admin\Form\Account\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Admin\Form\Account\AccountForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

class AccountFormFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = new AccountForm();
        $form->setHydrator(new DoctrineObject($container->get('Doctrine\ORM\EntityManager')));
        
        return $form;
    }
}