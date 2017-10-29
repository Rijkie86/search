<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Bolt;

class BoltController extends AbstractActionController
{

    private $formElementManager;

    private $boltService;

    public function __construct($formElementManager, $boltService)
    {
        $this->formElementManager = $formElementManager;
        
        $this->boltService = $boltService;
    }

    public function indexAction()
    {
        $objectId = $this->getEvent()
            ->getRouteMatch()
            ->getParam('id', null);
        
        $bolts = $this->boltService->findAll();
        
        $viewModel = new ViewModel();
        $viewModel->setVariables([
            'objectId' => $objectId,
            'bolts' => $bolts
        ]);
        
        return $viewModel;
    }

    public function createAction()
    {
        $objectId = $this->getEvent()
            ->getRouteMatch()
            ->getParam('id', null);
        
        $form = $this->formElementManager->get('boltForm');
        
        $bolt = new Bolt();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            
            $form->bind($bolt);
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $this->boltService->create($bolt);
            } else {
                var_dump($form->getMessages());
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
        $boltId = $this->getEvent()
            ->getRouteMatch()
            ->getParam('id', null);
        
        $bolt = $this->boltService->findOneBy([
            'id' => $boltId
        ]);
        
        $form = $this->formElementManager->get('boltForm');
        $form->bind($bolt);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                // $this->boltService->create($bolt);
            } else {
                var_dump($form->getMessages());
                die();
            }
        }
        
        $viewModel = new ViewModel();
        $viewModel->setVariables([
            'bolt' => $bolt,
            'form' => $form
        ]);
        
        return $viewModel;
    }

    public function copyAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setVariables();
        
        return $viewModel;
    }

    public function addSizeAction()
    {
        $boltId = $this->getEvent()
            ->getRouteMatch()
            ->getParam('id', null);
        
        $bolt = $this->boltService->findOneBy([
            'id' => $boltId
        ]);
        
        $form = $this->formElementManager->get('boltForm');
        $form->get('boltSize')->setCreateNewObjects(true);
        
        $form->setValidationGroup([
            'boltSize' => [
                'metric',
                'steelLength',
                'quality'
            ]
        ]);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            
            $form->bind($bolt);
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $this->boltService->edit($bolt);
            } else {
                var_dump($form->getMessages());
                die();
            }
        }
        
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true)->setVariables([
            'form' => $form,
            'boltId' => $bolt->getId()
        ]);
        
        return $viewModel;
    }

    public function editSizeAction()
    {
        $boltSizeId = $this->getEvent()
            ->getRouteMatch()
            ->getParam('id', null);
        
        /**
         *
         * @todo : Check if we are allowed to edit this record
         */
        
        $boltSize = $this->boltService->findBoltSize([
            'id' => $boltSizeId
        ]);
        
        $boltSize->setQuality($this->getRequest()
            ->getPost('value'));
        
        $bolt = $boltSize->getBolt();
        
        $this->boltService->edit($bolt);
        
        // $viewModel = new ViewModel();
        // $viewModel->setTerminal(true);
        
        // return $viewModel;
        
        return false;
    }
}
