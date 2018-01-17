<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Permissions\Acl\Acl;

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
        $start = 1;
        $length = 20;
        
        $filter = $this->formElementManager->get('productFilter');

        return new ViewModel([
            'filter' => $filter,
            'paginator' => $paginator = $this->productService->findBy([], $start, $length),
        ]);
    }

    public function findAllAjaxAction()
    {
        $start = $this->params()->fromPost('start');
        $length = $this->params()->fromPost('length');
        $filter = $this->params()->fromPost('filter');

        $paginator = $this->productService->findBy($filter, $start, $length);
        
        $rows = [];
        
        if (0 < count($paginator)) {
            foreach ($paginator as $productEntity) {
                
                $status = $productEntity->getStatus();
                
                $rows[] = [
                    '
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-xs ' . ($productEntity->getStatus() == 1 ? 'btn-success' : ($productEntity->getStatus() == 0 ? 'btn-danger disabled' : 'btn-default')) . ' dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    ' . ($productEntity->getStatus() == 0 ? 'Inactive' : 'Choose action <span class="caret"></span>') . '
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:" onclick="location.href = \'' . $productEntity->getUrl() . '\'">Visit</a></li>
                                    <li><a href="javascript:" onclick="location.href = \'/admin/product/edit/' . $productEntity->getId() . '\'">Edit</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a style="color: red;" href="#">Disable</a></li>
                                </ul>
                            </div>
                        </td>
                    ',
                    $productEntity->getUniqueId(),
                    $productEntity->getProgramId(),
                    (! empty($productEntity->getCategory()) ? $productEntity->getCategory()->getName() : null),
                    $productEntity->getName()
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
        
        $product = $this->productService->findOneBy([
            'id' => $productId
        ]);

        if ($productId === null) {
            return $this->redirect()->toRoute('application');
        }
        
        $viewModel = new ViewModel();
        $viewModel->setVariables([
            'productId' => $productId
        ]);
        
        return $viewModel;
    }
    
    public function propertiesAction()
    {
        $productEntity = $this->productService->findOneBy([
            'id' => $this->getEvent()
            ->getRouteMatch()
            ->getParam('id', null)
        ]);
        
        $form = $this->formElementManager->get('productForm');
        $form->bind($productEntity);

        $viewModel = new ViewModel();
        $viewModel->setTerminal(true)
        ->setTemplate('admin/product/partial/properties.phtml')
        ->setVariables([
            'form' => $form,
            'productEntity' => $productEntity
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
        $viewModel->setTerminal(true)
            ->setTemplate('admin/product/partial/info.phtml')
            ->setVariables([
            'form' => $form,
            'productEntity' => $productEntity
        ]);
        
        return $viewModel;
    }

    public function mediaAction()
    {
        $productEntity = $this->productService->findOneBy([
            'id' => $this->getEvent()
                ->getRouteMatch()
                ->getParam('id', null)
        ]);
        
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true)
            ->setTemplate('admin/product/partial/media.phtml')
            ->setVariables([
            'productEntity' => $productEntity
        ]);
        
        return $viewModel;
    }

    public function updateMediaAction()
    {
        $params = $this->params()->fromPost();
        
        $productEntity = $this->productService->findOneBy([
            'id' => $this->getEvent()
                ->getRouteMatch()
                ->getParam('id', null)
        ]);
        
        try {
            $response = $this->productService->updateMedia($productEntity, $params['pk'], $params['name'], $params['value']);
        } catch (\Exception $e) {
            $response = $e->getMessage();
        }
        
        return new JsonModel([
            'response' => $response
        ]);
    }

    public function seoAction()
    {
        $productEntity = $this->productService->findOneBy([
            'id' => $this->getEvent()
                ->getRouteMatch()
                ->getParam('id', null)
        ]);
        
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true)
            ->setTemplate('admin/product/partial/seo.phtml')
            ->setVariables([
            'productEntity' => $productEntity
        ]);
        
        return $viewModel;
    }

    public function updateSeoAction()
    {
        $params = $this->params()->fromPost();
        
        $productEntity = $this->productService->findOneBy([
            'id' => $this->getEvent()
                ->getRouteMatch()
                ->getParam('id', null)
        ]);
        
        try {
            $response = $this->productService->updateSeo($productEntity, $params['pk'], $params['name'], $params['value']);
        } catch (\Exception $e) {
            $response = $e->getMessage();
        }
        
        return new JsonModel([
            'response' => $response
        ]);
    }

    public function historyAction()
    {
        $productId = $this->getEvent()
            ->getRouteMatch()
            ->getParam('id', null);
        
        $product = $this->productService->findOneBy([
            'id' => $productId
        ]);
        
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true)
            ->setTemplate('admin/product/partial/history.phtml')
            ->setVariables([
            'product' => $product
        ]);
        
        return $viewModel;
    }

    public function statisticsAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true)->setTemplate('admin/product/partial/statistics.phtml');
        
        return $viewModel;
    }

    public function reviewsAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true)->setTemplate('admin/product/partial/reviews.phtml');
        
        return $viewModel;
    }
}
