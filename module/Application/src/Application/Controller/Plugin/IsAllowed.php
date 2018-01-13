<?php
namespace Application\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class IsAllowed extends AbstractPlugin
{

    private $authorize;

    public function __construct(\Application\Permissions\Authorize $authorize)
    {
        $this->authorize = $authorize;
    }

    public function __invoke($resource = null, $privilege = null)
    {
        return $this->authorize->isAllowed($resource, $privilege);
    }
}