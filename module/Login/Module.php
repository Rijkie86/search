<?php
namespace Login;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{

    public function onBootstrap($e)
    {
        $app = $e->getParam('application');
        $app->getEventManager()->attach('dispatch', array(
            $this,
            'setLayout'
        ));
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'Zend\Authentication\AuthenticationService' => function ($serviceManager) {
                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
                }
            ]
        ];
    }

    public function setLayout($e)
    {
        $matches = $e->getRouteMatch();
        $controller = $matches->getParam('controller');
        
        if (false === strpos($controller, __NAMESPACE__)) {
            return;
        }
        
        $viewModel = $e->getViewModel();
        $viewModel->setTemplate('layout/login');
    }
}
