<?php
namespace Application\Controller;

use Application\Entity\ChangelogProduct;
use Application\Entity\Feed;
use Application\Entity\FeedCategory;
use Application\Entity\FeedCategoryValue;
use Application\Entity\ProductImage;
use Application\Entity\Program;
use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Zend\View\Model\ViewModel;
use Application\Entity\Log;
use Application\Entity\FeedProductProperty;
use Doctrine\Common\Collections\Criteria;
use Application\Entity\Brand;
ini_set('memory_limit', '-1');

class ConsoleController extends AbstractActionController
{

    private $feedService;

    private $categoryService;

    private $productService;

    public function __construct($feedService, $categoryService, $productService, $entityManager)
    {
        $this->feedService = $feedService;
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        
        $this->entityManager = $entityManager;
    }

    public function promotioncodeAction()
    {
        echo 'Invalid XML.';
        // $file = 'https://export.daisycon.com/publishers/65420/material/promotioncodes/xml?username=erik.mij%40gmail.com&token=741c82d9fc7235f3fb7f32314559aab47038a0008835c8ca&language=nl&media_id=234775&program_id=&locale_id=1&category_id=&subscription_status=approved';
        // parse_str(parse_url($file, PHP_URL_QUERY), $queryData);
        
        // $fp = fopen('public/xml/promotioncode.xml', 'w');
        
        // $options = array(
        // CURLOPT_FILE => $fp,
        // CURLOPT_TIMEOUT => 28800,
        // CURLOPT_URL => $file
        // );
        
        // $ch = curl_init();
        // curl_setopt_array($ch, $options);
        // curl_exec($ch);
        // curl_close($ch);
    }

    public function feedListAction()
    {
        $this->feeds = $this->feedService->findAll();
        
        foreach ($this->feeds as $feed) {
            /**
             *
             * @todo : Can be removed later when there are no available feed with an empty file column.
             */
            if (! filter_var($feed->getFile(), FILTER_VALIDATE_URL)) {
                continue;
            }
            
            parse_str(parse_url($feed->getFile(), PHP_URL_QUERY), $queryData);
            
            $fp = fopen('public/xml/' . $queryData['filter_id'] . '.xml', 'w');
            
            $options = array(
                CURLOPT_FILE => $fp,
                CURLOPT_TIMEOUT => 28800,
                CURLOPT_URL => $feed->getFile()
            );
            
            $ch = curl_init();
            curl_setopt_array($ch, $options);
            curl_exec($ch);
            curl_close($ch);
        }
        
        return false;
    }

    public function updateFeedListAction()
    {
        $this->feeds = $this->feedService->findAll();
        
        $toBeDeleted = [];
        
        foreach ($this->feeds as $feed) {
            $feedProductPropertyCollection = $feed->getFeedProductProperty();
            
            parse_str(parse_url($feed->getFile(), PHP_URL_QUERY), $queryData);
            
            $doc = new \DOMDocument();
            
            $xmlReader = new \XMLReader();
            $xmlReader->open('public/xml/' . $queryData['filter_id'] . '.xml', 'UTF-8', LIBXML_NOERROR | LIBXML_NOWARNING);
            
            $bIsValid = false;
            
            $properties = [];
            
            while ($xmlReader->read()) {
                if ($xmlReader->nodeType == \XMLReader::ELEMENT && $xmlReader->name == 'product') {
                    $productNode = simplexml_import_dom($doc->importNode($xmlReader->expand(), true));
                    
                    foreach ($productNode->product_info->children() as $item) {
                        $properties[] = $item->getName();
                    }
                    
                    break;
                }
                
                if ($xmlReader->nodeType == \XMLReader::ELEMENT && $xmlReader->name == 'program_info') {
                    $node = simplexml_import_dom($doc->importNode($xmlReader->expand(), true));
                    
                    $programId = $node->id;
                    $productCount = $node->product_count;
                }
            }
            
            $feed->setProgramId((string) $programId)->setProductCount((string) $productCount);
            
            if (! empty($properties) && is_array($properties)) {
                foreach ($properties as $property) {
                    $exists = $feedProductPropertyCollection->exists(function ($test, $element) use ($feed, $property) {
                        return $element->getName() == $property && $element->getFeed() === $feed;
                    });
                    
                    if (! $exists) {
                        $feedProductProperty = new FeedProductProperty();
                        $feedProductProperty->setFeed($feed)->setName($property);
                        
                        $feed->addFeedProductProperty($feedProductProperty);
                    }
                }
            }
            
            $this->feedService->update($feed);
        }
        
        return false;
    }

    public function insertProductsAction()
    {
        $start = microtime(true);
        
        $this->feeds = $this->feedService->findAll();
        
        $filterIds = [];
        foreach ($this->feeds as $feed) {
            parse_str(parse_url($feed->getFile(), PHP_URL_QUERY), $queryData);
            
            $xmlReader = new \XMLReader();
            $xmlReader->open('public/xml/' . $queryData['filter_id'] . '.xml', 'UTF-8', LIBXML_NOERROR | LIBXML_NOWARNING);
            if ($xmlReader->read()) {
                $filterIds[$feed->getId()] = $queryData['filter_id'];
            }
        }
        
        foreach ($filterIds as $feedId => $filterId) {
            
            $doc = new \DOMDocument();
            
            $xmlReader = new \XMLReader();
            $xmlReader->open('public/xml/' . $filterId . '.xml', 'UTF-8', LIBXML_NOERROR | LIBXML_NOWARNING);
            
            $programId = null;
            
            $productCategories = [];
            
            while ($xmlReader->read()) {
                if ($xmlReader->nodeType == \XMLReader::ELEMENT && $xmlReader->name == 'program_info') {
                    $programNode = simplexml_import_dom($doc->importNode($xmlReader->expand(), true));
                    
                    $programId = (int) $programNode->id;
                    
                    if ($this->getEvent()
                        ->getRouteMatch()
                        ->getParam('programId', null) != null) {
                        if ((int) $this->getEvent()
                            ->getRouteMatch()
                            ->getParam('programId', null) !== $programId) {
                            continue (2);
                        }
                    }
                }
                
                if ($xmlReader->nodeType == \XMLReader::ELEMENT && $xmlReader->name == 'product') {
                    $productNode = simplexml_import_dom($doc->importNode($xmlReader->expand(), true));
                    
                    $updateProperties = [];
                    foreach ($productNode->update_info->children() as $item) {
                        $updateProperties[$item->getName()] = (string) $item;
                    }
                    
                    $productImages = $this->feedService->getProductImages($productNode);
                    $productProperties = $this->feedService->getProductProperties($productNode);
                    $productCategories = $this->feedService->getProductCategories($productNode);
                    
                    $productEntity = $this->productService->findOneBy([
                        'uniqueId' => $updateProperties['daisycon_unique_id']
                    ]);
                    
                    if ($productEntity == null) {
                        $productId = $this->insert($updateProperties, $productProperties, $productImages, $programId);
                    } else {
                        $productId = $productEntity->getId();
                        
                        $this->update($productEntity, $productProperties, $productImages, $productCategories);
                    }
                }
            }
            
            $this->feedService->updateLastRun($feedId, new \DateTime());
            
            $end = microtime(true);
            
            $execution_time = ($end - $start);
            
            echo '<b>Total Execution Time:</b> ' . $execution_time . ' seconds for feed: ' . $feedId . PHP_EOL;
        }
        
        return false;
    }

    private function insert($updateProperties, $productProperties, $productImages, $programId)
    {
        unset($productProperties['images']);
        
        $feed = $this->entityManager->getRepository('Application\Entity\Feed')->findOneBy([
            'programId' => $programId
        ]);
        
        $feedProductProperty = $feed->getFeedProductProperty();
        
        /**
         *
         * @todo : Remove setCategory
         */
        
        $productEntity = new \Application\Entity\Product();
        $productEntity->setUniqueId($updateProperties['daisycon_unique_id'])
            ->setFeed($feed)
            ->setProgramId($feed->getProgramId())
            ->setCategory($this->entityManager->getReference('Application\Entity\Category', 4));
        
        foreach ($productImages as $key => $value) {
            $productImage = new \Application\Entity\ProductImage();
            $productImage->setProduct($productEntity)->setName((string) $value->location);
            
            $productEntity->addProductImage($productImage);
        }
        
        foreach ($productProperties as $key => $value) {
            
            $matchedProperty = false;
            
            /*
             * @todo ...
             */
            if (is_array($value)) {
                continue;
            }
            
            /**
             *
             * @todo $feedProductProperty needs to provide information how to handle the properties
             *       new object, foreign key etc...
             */
            $exists = $feedProductProperty->exists(function ($Hanneke, $element) use ($key) {
                if ($element->getName() == $key && $element->getListObject() != null && $element->getDbTableProperty() != null) {
                    return true;
                }
            });
            
            $element = $feedProductProperty->filter(function ($element) use ($key) {
                if ($element->getName() == $key) {
                    return $element;
                }
            });
            
            if ($element->first()->getActive() === false) {
                continue;
            }
            
            if (in_array($key, [
                'brand',
                'brand_logo'
            ])) {
                if ($exists) {
                    $setter = 'set' . ucfirst($element->first()->getDbTableProperty());
                    
                    if ($productEntity->getBrand()->count() < 1) {
                        $brand = new Brand();
                        $brand->$setter($value);
                        
                        $productEntity->addBrand($brand);
                    } else {
                        $brand = $productEntity->getBrand()->first();
                        $brand->$setter($value);
                    }
                    
                    $matchedProperty = true;
                }
            } elseif ($key == 'link') {
                if ($exists) {
                    $setter = 'set' . ucfirst($element->first()->getDbTableProperty());
                    
                    $productEntity->$setter($value);
                    
                    $matchedProperty = true;
                }
            } elseif ($key == 'description') {
                if ($exists) {
                    $setter = 'set' . ucfirst($element->first()->getDbTableProperty());
                    
                    $productEntity->$setter($value);
                    
                    $matchedProperty = true;
                }
            } elseif ($key == 'title') {
                if ($exists) {
                    $setter = 'set' . ucfirst($element->first()->getDbTableProperty());
                    
                    $productEntity->$setter($value);
                    
                    $matchedProperty = true;
                }
            } elseif ($key == 'price') {
                if ($exists) {
                    $setter = 'set' . ucfirst($element->first()->getDbTableProperty());
                    
                    $productEntity->$setter($value);
                    
                    $matchedProperty = true;
                }
            }
            
            if ($matchedProperty == false) {
                $propertyEntity = new \Application\Entity\Property();
                $propertyEntity->setProduct($productEntity)
                    ->setName($key)
                    ->setValue($value);
                
                $productEntity->addProperty($propertyEntity);
            }
        }
        
        return $this->productService->create($productEntity);
    }

    private function update($productEntity, $productProperties, $productImages, $productCategories)
    {
        $this->productService->updateProperties($productEntity, $productProperties);
        $this->productService->updateImages($productEntity, $productImages);
        $this->productService->updateCategories($productEntity, $productCategories);
    }

    public function deleteAction()
    {
        $stdin = fopen('php://stdin', 'r');
        $yes = false;
        
        while (! $yes) {
            echo "\033[31mReset the database? (Y/N)\033[0m: ";
            
            $input = strtolower(trim(fgets($stdin)));
            
            if ($input == 'y') {
                $this->productService->reset();
                
                exit();
            }
        }
        
        return false;
    }

    public function elasticsearchAction()
    {
        $client = \Elasticsearch\ClientBuilder::create()->setHosts([
            '149.210.204.168:9200'
        ])->build();
        
        $client->indices()->delete([
            'index' => 'productsearch'
        ]);
    }
}
