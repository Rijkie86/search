<?php
namespace Login\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    private $authenticationService;

    public function __construct($authenticationService, $formElementManager)
    {
        $this->authenticationService = $authenticationService;
        
        $this->formElementManager = $formElementManager;
    }

    public function indexAction()
    {
        $form = $this->formElementManager->get('loginForm');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $adapter = $this->authenticationService->getAdapter();
                $adapter->setIdentity($request->getPost('email'));
                $adapter->setCredential($request->getPost('password'));
                
                $authenticationResult = $this->authenticationService->authenticate();
                
                if ($authenticationResult->isValid()) {
                    $identity = $authenticationResult->getIdentity();
                    
                    $this->authenticationService->getStorage()->write($identity);
                    
                    return $this->redirect()->toRoute('home');
                }
            } else {
                var_dump($form->getMessages());
            }
        }
        
        return new ViewModel(array(
            'form' => $form
        ));
        
        $authenticationResult = $this->authenticationService->authenticate();
        
        $viewModel = new ViewModel();
        
        return $viewModel;
    }

    public function changePasswordAction()
    {
        $viewModel = new ViewModel();
        
        return $viewModel;
    }
}
