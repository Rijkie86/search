<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Application\Entity\Feed;
use Zend\Permissions\Acl\Resource\ResourceInterface;
use Application\Entity\FeedProductProperty;
use Doctrine\Common\Collections\Criteria;
use Application\Entity\ListObject;

class FeedController extends AbstractActionController implements ResourceInterface
{

    private $entityManager;

    private $formElementManager;

    public function __construct($feedService, $formElementManager)
    {
        $this->feedService = $feedService;
        
        $this->formElementManager = $formElementManager;
    }

    public function getResourceId()
    {
        return 'feed';
    }

    public function indexAction()
    {
        if (! $this->isAllowed($this, 'feed-view')) {
            return false;
        }
        
        $feeds = $this->feedService->findAll();
        
        $viewModel = new ViewModel();
        $viewModel->setVariables([
            'feeds' => $feeds
        ]);
        
        return $viewModel;
    }

    public function createAction()
    {
        $this->isAllowed($this, 'feed-create');
        
        $form = $this->formElementManager->get('feedForm');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $feed = new Feed();
            
            $form->bind($feed);
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $this->feedService->create($feed);
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
        if (! $this->isAllowed($this, 'feed-create')) {
            return false;
        }
        
        $feedId = $this->getEvent()
            ->getRouteMatch()
            ->getParam('id');
        
        return new ViewModel(array(
            'feedId' => $feedId
        ));
    }

    public function settingsAction()
    {
        $feedId = $this->getEvent()
            ->getRouteMatch()
            ->getParam('id');
        
        $feed = $this->feedService->findOneBy([
            'id' => $feedId
        ]);
        
        $form = $this->formElementManager->get('feedForm');
        $form->bind($feed);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->feedService->update($feed);
            } else {
                var_dump($form->getMessages());
            }
        }
        
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true)
            ->setTemplate('admin/feed/partial/settings.phtml')
            ->setVariables([
            'form' => $form
        ]);
        
        return $viewModel;
    }

    public function propertiesAction()
    {
        if (! $this->isAllowed($this, 'feed-view-properties')) {
            return false;
        }
        
        $feed = $this->feedService->findOneBy([
            'id' => $this->getEvent()
                ->getRouteMatch()
                ->getParam('id', null)
        ]);
        
        return new ViewModel(array(
            'feed' => $feed
        ));
    }

    public function linkPropertiesAction()
    {
        if (! $this->isAllowed($this, 'feed-link-properties')) {
            return false;
        }
        
        $feedId = $this->getEvent()
            ->getRouteMatch()
            ->getParam('id');
        
        $propertyId = $this->getEvent()
            ->getRouteMatch()
            ->getParam('propertyId');
        
        $feed = $this->feedService->findOneBy([
            'id' => $feedId
        ]);
        
        $criteria = Criteria::create()->where(Criteria::expr()->eq('id', $propertyId));
        
        $feedProductProperty = $feed->getFeedProductProperty();
        
        $form = $this->formElementManager->get('linkForm');
        $form->bind($feedProductProperty->matching($criteria)
            ->first());
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->feedService->update();
            } else {
                \Doctrine\Common\Util\Debug::dump($form->getMessages());
            }
        }
        
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true)->setVariables([
            'form' => $form,
            'feedId' => $feedId,
            'propertyId' => $propertyId,
            'feedProductProperty' => $feedProductProperty->matching($criteria)
                ->first()
        ]);
        
        return $viewModel;
    }

    public function linkPropertiesAjaxAction()
    {
        if (! $this->isAllowed($this, 'feed-link-properties')) {
            return false;
        }
        
        $feedId = $this->getEvent()
            ->getRouteMatch()
            ->getParam('id');
        
        $propertyId = $this->getEvent()
            ->getRouteMatch()
            ->getParam('propertyId');
        
        $feed = $this->feedService->findOneBy([
            'id' => $feedId
        ]);
        
        $criteria = Criteria::create()->where(Criteria::expr()->eq('id', $propertyId));
        
        $feedProductPropertyCollection = $feed->getFeedProductProperty();
        
        $feedProductProperty = $feedProductPropertyCollection->matching($criteria)->first();
        
        $form = $this->formElementManager->get('linkForm');
        $form->bind($feedProductProperty);
        
        $data = [];
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                
                $feedProductProperty->setModifiedDate(new \DateTime())->setLocked(true);
                
                $this->feedService->updateFeedProductProperty($feedProductProperty);
                
                $data = [
                    'return' => true
                ];
            } else {
                $data = [
                    'return' => 'An error occured, please try again later.'
                ];
                
                \Doctrine\Common\Util\Debug::dump($form->getMessages());
                die();
            }
        }
        
        $viewModel = new JsonModel($data);
        
        return $viewModel;
    }

    public function getPropertiesAction()
    {
        $data = $this->feedService->getColumns($this->getEvent()
            ->getRouteMatch()
            ->getParam('id'));
        
        $viewModel = new JsonModel($data);
        
        return $viewModel;
    }
}
