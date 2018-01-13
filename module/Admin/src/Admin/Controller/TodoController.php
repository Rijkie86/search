<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\User;
use Zend\Permissions\Acl\Resource\ResourceInterface;
use Application\Entity\Todo;

class TodoController extends AbstractActionController implements ResourceInterface
{

    private $formElementManager;
    
    private $todoService;
    
    public function __construct($formElementManager, $todoService)
    {
        $this->formElementManager = $formElementManager;
        
        $this->todoService = $todoService;
    }
    
    public function getResourceId()
    {
        return 'todo';
    }

    public function indexAction()
    {
        if (! $this->isAllowed($this, 'todo-view')) {
            return false;
        }
        
        $todos = $this->todoService->findAll();
        
        $viewModel = new ViewModel();
        $viewModel->setVariables([
            'todos' => $todos
        ]);
        
        return $viewModel;
    }

    public function createAction()
    {
        if (! $this->isAllowed($this, 'todo-create')) {
            return false;
        }
        
        $form = $this->formElementManager->get('workItemForm');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $workItem = new Todo();
            
            $form->bind($workItem);
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $this->todoService->create($workItem);
            } else {
                var_dump($form->getMessages());
            }
        }
        
        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function updateAction()
    {
//         $boltId = $this->getEvent()
//             ->getRouteMatch()
//             ->getParam('id', null);
        
//         $bolt = $this->boltService->findOneBy([
//             'id' => $boltId
//         ]);
        
//         $form = $this->formElementManager->get('boltForm');
//         $form->bind($bolt);
        
//         $request = $this->getRequest();
//         if ($request->isPost()) {
            
//             $form->setData($request->getPost());
            
//             if ($form->isValid()) {
//                 // $this->boltService->create($bolt);
//             } else {
//                 var_dump($form->getMessages());
//                 die();
//             }
//         }
        
        $viewModel = new ViewModel();
//         $viewModel->setVariables([
//             'bolt' => $bolt,
//             'form' => $form
//         ]);
        
        return $viewModel;
    }
}
