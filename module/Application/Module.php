<?php
namespace Application;

use Zend\ServiceManager\AbstractPluginManager;

class Module
{

    public function onBootstrap(\Zend\Mvc\MvcEvent $e)
    {
        $application = $e->getApplication();
        
        $serviceManager = $application->getServiceManager();
        $authenticationService = $serviceManager->get('Zend\Authentication\AuthenticationService');
        
        $authenticatedUser = $authenticationService->getIdentity();

        if (php_sapi_name() != 'cli') {
            if ($authenticatedUser == null && $e->getRequest()
                ->getUri()
                ->getPath() !== '/login') {
                    $response = $e->getResponse();
                    $response->getHeaders()->addHeaderLine('Location', '/login');
                    $response->setStatusCode(301);
                    $response->sendHeaders();
                    
                    return $response;
                }
        }
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

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
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

    public function getControllerPluginConfig()
    {
        return array(
            'factories' => array(
                'isAllowed' => function ($serviceManager) {
                    $authorize = $serviceManager->get('authorize');

                    return new Controller\Plugin\IsAllowed($authorize);
                }
            )
        );
    }
}