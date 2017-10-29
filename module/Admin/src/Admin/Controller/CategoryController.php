<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Application\Entity\Category;

class CategoryController extends AbstractActionController
{

    private $entityManager;

    private $formElementManager;

    public function __construct($categoryService, $formElementManager, $feedCategoryValueService)
    {
        $this->categoryService = $categoryService;
        $this->feedCategoryValueService = $feedCategoryValueService;
        
        $this->formElementManager = $formElementManager;
    }

    public function indexAction()
    {
        $categories = $this->categoryService->findBy([
            'parent' => null
        ]);
        
        return new ViewModel(array(
            'categories' => $categories
        ));
    }

    public function createAction()
    {
        $form = $this->formElementManager->get('categoryForm');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $category = new Category();
            
            $form->bind($category);
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $this->categoryService->create($category);
            } else {
                var_dump($form->getMessages());
            }
        }
        
        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function createAjaxAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $category = new Category();
            
            $this->categoryService->add($category, $this->params()
                ->fromPost('parentId', null));
            
            return new JsonModel(array(
                'categoryId' => $category->getId()
            ));
        }
        
        return new JsonModel();
    }

    public function renameAjaxAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $nodeData = $this->params()->fromPost('node', null);

            $this->categoryService->rename($nodeData);
        }
        
        return new JsonModel();
    }

    public function deleteAjaxAction()
    {
        $nodeData = $this->params()->fromPost('node', null);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $category = $this->entityManager->getReference('Application\Entity\Category', $nodeData['id']);
            
            $this->entityManager->remove($category);
            $this->entityManager->flush();
        }
        
        return new JsonModel();
    }

    public function productsAction()
    {
        $products = $this->entityManager->getRepository('Application\Entity\Product')->findBy([
            'category' => 1
        ]);
        
        $viewModel = new ViewModel();
        $viewModel->setVariables([
            'products' => $products
        ]);
        
        return $viewModel;
    }

    public function linkAction()
    {
        $categories = $this->categoryService->findBy([
            'parent' => null
        ]);
        
        return new ViewModel(array(
            'categories' => $categories,
            'feedCategoryValueId' => $this->getEvent()
                ->getRouteMatch()
                ->getParam('id')
        ));
        
        return new ViewModel();
    }

    public function linkAjaxAction()
    {
        $categories = [];
        
        $feedCategoryValue = $this->feedCategoryValueService->findOneBy(['id' => $this->getEvent()->getRouteMatch()->getParam('id')]);

        $this->feedCategoryValueService->addToCategories($feedCategoryValue, $this->getRequest()->getPost('selectedNodes'));

        return new JsonModel();
    }

    public function editAction()
    {
        $categoryId = $this->getEvent()
            ->getRouteMatch()
            ->getParam('id');
        
        $form = $this->formElementManager->get('Admin\Form\Category\CategoryForm');
        
        $category = $this->categoryService->findOneBy(['id' => $categoryId]);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->bind($category);
            $form->setData($request->getPost());
            if ($form->isValid()) {
                // save
            } else {
                var_dump($form->getMessages());
            }
        }
        
        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function matchAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setVariables([
            'categories' => $this->categoryService->findBy([
                'parent' => null
            ])
        ]);
        
        return $viewModel;
    }

    public function testAction()
    {
        $post = $this->getRequest()->getPost('depdrop_parents');
        
        $value = end($post);
        
        $categoryCollection = $this->entityManager->getRepository('Application\Entity\Category')->findBy([
            'parent' => $value
        ]);
        
        $categories = [
            'output'
        ];
        foreach ($categoryCollection as $category) {
            $categories['output'][] = [
                'id' => $category->getId(),
                'name' => $category->getName()
            ];
        }
        
        return new JsonModel($categories);
    }

    public function matchingAction()
    {
        $start = $this->params()->fromPost('start');
        $length = $this->params()->fromPost('length');

        $paginator = $this->categoryService->getUnassignedFeedCategoryValues($start, $length);

        $rows = [];
        
        if (0 < count($paginator)) {
            foreach ($paginator as $feedCategoryValue) {
                // if($feedCategoryValue->getCategory()->isEmpty()) {
                $rows[] = [
                    '<a href="/admin/category/link/' . $feedCategoryValue->getId() . '">' . $feedCategoryValue->getName() . '</a>'
                ];
                // }
            }
        }
        
        return new JsonModel([
            "recordsTotal" => $paginator->count(),
            "recordsFiltered" => $paginator->count(),
            "data" => $rows
        ]);
    }
}
