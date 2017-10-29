<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    private $websiteService;

    public function __construct($websiteService)
    {
        $this->websiteService = $websiteService;
    }

    public function indexAction()
    {
        $websites = $this->websiteService->findAll();
        
        $viewModel = new ViewModel();
        $viewModel->setVariables([
            'websites' => $websites
        ]);
        
        return $viewModel;
    }
}