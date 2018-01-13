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

    public function searchAction()
    {
        if (! empty($this->params()->fromPost('q'))) {
            $client = \Elasticsearch\ClientBuilder::create()->setHosts([
                '149.210.204.168:9200'
            ])->build();
            
            $params = [
                'index' => 'productsearch',
                'type' => 'product',
                'body' => [
                    "suggest" => [
                        "song-suggest" => [
                            "prefix" => (string) $this->params()->fromPost('q'),
                            "completion" => [
                                "field" => "suggest",
                                "fuzzy" => [
                                    "fuzziness" => 1
                                ]
                            ]
                        ]
                    ]
                ]
            ];

            $results = $client->search($params);
            
            $viewModel = new ViewModel();
            $viewModel->setVariables([
                'data' => $results
            ]);
        }
        
        // $viewModel = new ViewModel();
        
        return $viewModel;
    }
}