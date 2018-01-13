<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Bolt;
use Application\Entity\ComparisonTool;

class ComparisonToolController extends AbstractActionController
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
        $form = $this->formElementManager->get('comparisonToolForm');
        
        $request = $this->getRequest();
        if($request->isPost()) {
            $comparisonTool = new ComparisonTool();
            $form->setData($request->getPost());
            if($form->isValid()) {
                /**
                 * Let the service save this comparison tool
                 */
            } else {
                \Doctrine\Common\Util\Debug::dump($form->getMessages());
            }
        }
        
        $viewModel = new ViewModel();
        $viewModel->setVariables([
            'form' => $form
        ]);
        
        return $viewModel;
    }
}
