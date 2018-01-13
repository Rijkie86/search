<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Permissions\Acl\AclInterface;
use Zend\Permissions\Acl\Role\RoleInterface;
use Zend\Permissions\Acl\Resource\GenericResource;
use Zend\Permissions\Acl\Resource\ResourceInterface;

class IsAllowed extends AbstractHelper
{

    protected $acl;

    protected $role;

    protected static $defaultAcl;

    protected static $defaultRole;

    public function __invoke($resource = null, $privilege = null)
    {
        if (is_null($resource)) {
            return $this;
        }
        
        return $this->isAllowed($resource, $privilege);
    }

    public function isAllowed($resource, $privilege = null)
    {
        $acl = $this->getAcl();
        if (! $acl instanceof AclInterface) {
            throw new \RuntimeException('No ACL provided');
        } elseif (! $resource instanceof ResourceInterface) {
            $resource = new GenericResource($resource);
        }
        
        return $acl->isAllowed($resource, $privilege);
    }

    public static function setDefaultAcl(AclInterface $acl = null)
    {
        self::$defaultAcl = $acl;
    }

    public function setAcl(AclInterface $acl = null)
    {
        $this->acl = $acl;
        return $this;
    }

    protected function getAcl()
    {
        if ($this->acl instanceof AclInterface) {
            return $this->acl;
        }
        
        return self::$defaultAcl;
    }

    public static function setDefaultRole(RoleInterface $role = null)
    {
        self::$defaultRole = $role;
    }

    public function setRole(RoleInterface $role = null)
    {
        $this->role = $role;
        return $this;
    }

    protected function getRole()
    {
        if ($this->role instanceof RoleInterface) {
            return $this->role;
        }
        
        return self::$defaultRole;
    }
}
 