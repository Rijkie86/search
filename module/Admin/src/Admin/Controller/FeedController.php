<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Feed;

class FeedController extends AbstractActionController
{

    private $entityManager;

    private $formElementManager;

    public function __construct($feedService, $formElementManager)
    {
        $this->feedService = $feedService;
        
        $this->formElementManager = $formElementManager;
    }

    public function indexAction()
    {
        $feeds = $this->feedService->findAll();
        
        return new ViewModel(array(
            'feeds' => $feeds
        ));
    }

    public function createAction()
    {
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

    public function propertiesAction()
    {
        $feed = $this->feedService->findOneBy([
            'id' => $this->getEvent()
                ->getRouteMatch()
                ->getParam('id', null)
        ]);
        
        return new ViewModel(array(
            'feed' => $feed
        ));
    }
}
