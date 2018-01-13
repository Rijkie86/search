<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PromotioncodeController extends AbstractActionController
{

    private $formElementManager;

    public function __construct($formElementManager)
    {
        $this->formElementManager = $formElementManager;
    }

    public function indexAction()
    {        
        $viewModel = new ViewModel();

        return $viewModel;
    }

    public function createAction()
    {        
        $viewModel = new ViewModel();

        return $viewModel;
    }

    public function updateAction()
    {        
        $viewModel = new ViewModel();

        return $viewModel;
    }

    public function deleteAction()
    {
        $viewModel = new ViewModel();

        return $viewModel;
    }
}
