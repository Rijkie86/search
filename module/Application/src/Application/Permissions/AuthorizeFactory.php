<?php
namespace Application\Permissions;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Permissions\Authorize;

class AuthorizeFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authenticationService = $container->get('Zend\Authentication\AuthenticationService');

        return new Authorize($authenticationService);
    }
}