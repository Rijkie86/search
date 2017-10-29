<?php
namespace Application;

class Module
{

    public function onBootstrap(\Zend\Mvc\MvcEvent $e)
    {
        $application = $e->getApplication();
        
        $sm = $application->getServiceManager();
        
        $doctrineEntityManager = $sm->get('doctrine.entitymanager.orm_default');
        
        $doctrineEventManager = $doctrineEntityManager->getEventManager();
        $doctrineEventManager->addEventListener(array(
            \Doctrine\ORM\Events::onFlush,
        ), new \Application\Entity\Listener\MyEntityListener($sm));
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
}