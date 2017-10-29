<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class ProductController extends AbstractActionController
{

    private $formElementManager;

    private $productService;

    public function __construct($formElementManager, $productService)
    {
        $this->formElementManager = $formElementManager;
        $this->productService = $productService;
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function findAllAjaxAction()
    {
        $paginator = $this->productService->findBy($this->params());
        
        $rows = [];
        
        if (0 < count($paginator)) {
            foreach ($paginator as $productEntity) {
                $rows[] = [
                    $productEntity->getUniqueId(),
                    $productEntity->getProgramId(),
                    (! empty($productEntity->getCategory()) ? $productEntity->getCategory()->getName() : null),
                    $productEntity->getName(),
                    '<a href="' . $productEntity->getUrl() . '"><i class="fa fa-external-link" aria-hidden="true"></i></a>',
                    '<a href="/admin/product/edit/' . $productEntity->getId() . '"><i class="fa fa-eye" aria-hidden="true"></i></a>'
                ];
            }
        }
        
        return new JsonModel([
            'recordsTotal' => $paginator->count(),
            'recordsFiltered' => $paginator->count(),
            'data' => $rows
        ]);
    }

    public function createAction()
    {
        $form = $this->formElementManager->get('productForm');
        
        $viewModel = new ViewModel();
        $viewModel->setVariables([
            'form' => $form
        ]);
        
        return $viewModel;
    }

    public function editAction()
    {
        $productId = $this->getEvent()
            ->getRouteMatch()
            ->getParam('id', null);
        
        if ($productId === null) {
            return $this->redirect()->toRoute('application');
        }
        
        $viewModel = new ViewModel();
        $viewModel->setVariables([
            'productId' => $productId
        ]);
        return $viewModel;
    }

    public function infoAction()
    {
        $productEntity = $this->productService->findOneBy([
            'id' => $this->getEvent()
                ->getRouteMatch()
                ->getParam('id', null)
        ]);
        
        $form = $this->formElementManager->get('productForm');
        $form->bind($productEntity);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->entityManager->flush();
            } else {
                var_dump($form->getMessages());
            }
        }
        
        $viewModel = new ViewModel();
        $viewModel->setVariables([
            'form' => $form
        ]);
        $viewModel->setTerminal(true)
            ->setTemplate('admin/product/partial/info.phtml')
            ->setVariables([
            'productEntity' => $productEntity
        ]);
        
        return $viewModel;
    }

    public function imagesAction()
    {
        $productEntity = $this->productService->findOneBy([
            'id' => $this->getEvent()
                ->getRouteMatch()
                ->getParam('id', null)
        ]);
        
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true)
            ->setTemplate('admin/product/partial/images.phtml')
            ->setVariables([
            'productEntity' => $productEntity
        ]);
        
        return $viewModel;
    }

    public function seoAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true)->setTemplate('admin/product/partial/seo.phtml');
        
        return $viewModel;
    }

    public function historyAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true)->setTemplate('admin/product/partial/history.phtml');
        
        return $viewModel;
    }

    public function statisticsAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true)->setTemplate('admin/product/partial/statistics.phtml');
        
        return $viewModel;
    }
}
