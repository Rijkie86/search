<?php
namespace Application\Permissions;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole;

class Authorize extends Acl
{

    private $authenticationService;

    public function __construct(\Zend\Authentication\AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
        
        $this->addRole(new GenericRole('Administrator'));
        
        $this->addResource('account');
        $this->AddResource('feed');
        $this->addResource('product');
        $this->addResource('todo');
        
        $this->allow('Administrator', [
            'account',
            'feed',
            'product',
            'todo'
        ], [
            'view-product',
            'edit-product',
            
            'view-statistics',
            
            'view-media',
            'update-media',
            
            'view-reviews',
            'edit-reviews',
            
            'view-seo',
            'update-seo',
            
            'update-account',
            
            'reset-password',
            
            'feed-view',
            'feed-create',
            'feed-view-properties',
            'feed-link-properties',
            
            'todo-close',
            'todo-create',
            'todo-view',
            'todo-view-work-items',
            'todo-view-latest-reviews'
        ]);
    }

    public function isAllowed($resource = null, $privilege = null, $test = null)
    {
        if(php_sapi_name() != 'cli') {
            return parent::isAllowed($this->authenticationService->getIdentity()->getRole()->getName(), $resource, $privilege);
        }
        
        return true;
    }
    
    public function getAuthenticationService()
    {
        return $this->authenticationService;
    }
}