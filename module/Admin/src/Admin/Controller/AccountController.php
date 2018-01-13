<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\User;

class AccountController extends AbstractActionController
{

    private $formElementManager;

    private $accountService;

    public function __construct($formElementManager, $accountService)
    {
        $this->formElementManager = $formElementManager;
        
        $this->accountService = $accountService;
    }

    public function indexAction()
    {
        $accounts = $this->accountService->findAll();
        
        $viewModel = new ViewModel();
        $viewModel->setVariables([
            'accounts' => $accounts
        ]);
        
        return $viewModel;
    }

    public function createAction()
    {
        $form = $this->formElementManager->get('accountForm');
        
        $user = new User();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            
            $form->bind($user);
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $this->accountService->create($user);
            } else {
                \Doctrine\Common\Util\Debug::dump($form->getMessages());
                die();
            }
        }
        
        $viewModel = new ViewModel();
        $viewModel->setVariables([
            'form' => $form
        ]);
        
        return $viewModel;
    }

    public function editAction()
    {
        // $boltId = $this->getEvent()
        // ->getRouteMatch()
        // ->getParam('id', null);
        
        // $bolt = $this->boltService->findOneBy([
        // 'id' => $boltId
        // ]);
        
        // $form = $this->formElementManager->get('boltForm');
        // $form->bind($bolt);
        
        // $request = $this->getRequest();
        // if ($request->isPost()) {
        
        // $form->setData($request->getPost());
        
        // if ($form->isValid()) {
        // // $this->boltService->create($bolt);
        // } else {
        // var_dump($form->getMessages());
        // die();
        // }
        // }
        $viewModel = new ViewModel();
        // $viewModel->setVariables([
        // 'bolt' => $bolt,
        // 'form' => $form
        // ]);
        
        return $viewModel;
    }
}
