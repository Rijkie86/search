<?php
namespace Application\View\Helper\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\View\Helper\IsAllowed;
use Zend\Permissions\Acl\Role\GenericRole;

class IsAllowedFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $helper = new IsAllowed();
        $helper->setAcl($container->get('authorize'))->setRole(new GenericRole('Administrator'));
        
        return $helper;
    }
}