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
        
        $elasticaClient = new \Elastica\Client();
    }

    public function __destruct()
    {
        $this->productService->clean();
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
        
        // $log = new Log();
        // $log->setValue('New XML file download.');
        
        // $this->entityManager->persist($log);
        // $this->entityManager->flush();
        
        return false;
    }

    public function updateFeedListAction()
    {
        $this->feeds = $this->feedService->findAll();
        
        $toBeDeleted = [];
        
        foreach ($this->feeds as $feed) {
            /**
             *
             * @todo : Can be removed later when there are no available feed with an empty file column.
             */
            if (! filter_var($feed->getFile(), FILTER_VALIDATE_URL)) {
                continue;
            }
            
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
                    $feedProductProperty = new FeedProductProperty();
                    $feedProductProperty->setFeed($feed)->setName($property);
                    
                    $feed->addFeedProductProperty($feedProductProperty);
                }
            }
            
            $this->feedService->edit($feed);
            
            //
            // }
            
            // $bIsValid = true;
            // }
            // }
            
            // if ($bIsValid === false) {
            // $toBeDeleted[] = $feed;
            // }
            
            // $xmlReader->close();
        }
        
        // if (! empty($toBeDeleted)) {
        // $this->feedService->deleteAll($toBeDeleted);
        // }
        
        return false;
    }

    public function insertProductsAction()
    {
        $this->feeds = $this->feedService->findAll();
        
        $filterIds = [];
        foreach ($this->feeds as $feed) {
            /**
             *
             * @todo : Can be removed later when there are no available feed with an empty file column.
             */
            if (! filter_var($feed->getFile(), FILTER_VALIDATE_URL)) {
                continue;
            }
            
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
                    $productCategories[] = $this->feedService->getProductCategories($productNode);
                    
                    $productEntity = $this->productService->findOneBy([
                        'uniqueId' => $updateProperties['daisycon_unique_id']
                    ]);
                    
                    if (! empty($productImages)) {
                        // $productProperties['images'] = $productImages;
                    }
                    
                    if ($productEntity == null) {
                        $this->insert($updateProperties, $productProperties, $productImages, $programId);
                    } else {
                        if (! empty($categories)) {
                            // $productProperties['categories'] = implode('{__}', $categories);
                        }
                        $this->update($productEntity, $productProperties, $productImages, []);
                    /**
                     * , $productCategories*
                     */
                    }
                }
                
                // $xmlReader->close();
            }
            
            // $this->deactivateProducts($a);
            
            $categories = array_unique(array_reduce($productCategories, 'array_merge', []));
            
            // $categoriesForFeed = $this->categoryService->findBy(['program_id' => $programId]);
            
            // var_dump(get_class($categoriesForFeed));die;
            
            foreach ($categories as $category) {
                if (! $this->feedService->exists($feedId, $category)) {
                    $this->feedService->addFeedCategoryValue($feedId, $category);
                }
            }
            
            // $this->addFeedCategory($programId, $categories);
        }
        
        return false;
    }

    private function deactivateProduct($uniqueId)
    {
        throw new \Exception('Build this function');
    }

    private function deactivateProducts($uniqueIds)
    {
        if (! empty($uniqueIds) && is_array($uniqueIds)) {
            foreach ($uniqueIds as $uniqueId) {
                $this->deactivateProduct($uniqueId);
            }
        }
    }

    private function getFeedCategoryValues($collection)
    {
        $categories = [];
        
        foreach ($collection as $entity) {
            $categories[$entity->getId()] = $entity->getName();
        }
        
        return $categories;
    }

    private function addFeedCategory($programId, $categories)
    {
        // $feed = $this->entityManager->getRepository('Application\Entity\Feed')->findOneBy([
        // 'programId' => $programId
        // ]);
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('f')
            ->from('Application\Entity\Feed', 'f')
            ->where('f.programId = ?1')
            ->setParameter(1, $programId);
        
        $query = $queryBuilder->getQuery();
        $result = $query->getResult();
        $feed = $result[0];
        
        // \Doctrine\Common\Util\Debug::dump($feed);die;
        
        $feedCategory = $feed->getFeedCategory();
        
        if ($feedCategory !== null) {
            $feedCategoryValue = $feedCategory->getFeedCategoryValue();
            
            if ($feedCategoryValue->isEmpty()) {
                // die('1');
                $this->insertFeedCategory($feed, $categories);
            } else {
                $currentCategories = $this->getFeedCategoryValues($feedCategoryValue);
                
                $this->compareFeedCategories($currentCategories, $categories);
            }
        } else {
            // die('3');
            $this->insertFeedCategory($feed, $categories);
        }
    }

    private function insert($updateProperties, $productProperties, $productImages, $programId)
    {
        unset($productProperties['images']);
        
        $feed = $this->entityManager->getRepository('Application\Entity\Feed')->findOneBy([
            'programId' => $programId
        ]);
        
        /**
         *
         * @todo : Remove setCategory
         */
        
        $productEntity = new \Application\Entity\Product();
        $productEntity->setUniqueId($updateProperties['daisycon_unique_id'])
            ->setFeed($feed)
            ->setName($productProperties['title'])
            ->setProgramId($feed->getProgramId())
            ->setUrl($productProperties['link'])
            ->setDescription($productProperties['description'])
            ->setCategory($this->entityManager->getReference('Application\Entity\Category', 4));
        
        foreach ($productImages as $key => $value) {
            $productImage = new \Application\Entity\ProductImage();
            $productImage->setProduct($productEntity)->setName((string) $value->location);
            
            $productEntity->addProductImage($productImage);
        }
        
        foreach ($productProperties as $key => $value) {
            /*
             * @todo ...
             */
            if (is_array($value)) {
                continue;
            }
            
            $propertyEntity = new \Application\Entity\Property();
            $propertyEntity->setProduct($productEntity)
                ->setName($key)
                ->setValue($value);
            
            $productEntity->addProperty($propertyEntity);
        }

        $this->productService->create($productEntity);
    }

    private function update($productEntity, $productProperties, $productImages, $productCategories)
    {
        $properties = [];
        
        $propertiesCollection = $productEntity->getProperty();
        
        if (! $propertiesCollection->isEmpty()) {
            foreach ($propertiesCollection as $property) {
                $properties[$property->getName()] = $property->getValue();
            }
        }
        
        // $differences = array_merge(array_diff($productProperties, $properties), array_diff($properties, $productProperties));
        
        // if (! empty($differences)) {
        $this->productService->updateProperties($productEntity, $productProperties);
        $this->productService->updateImages($productEntity, $productImages);
        
        // }
        // $this->addFeedCategory($productEntity->getProgramId(), $productCategories);
        
        // foreach ($productProperties as $key => $property) {
        // if (array_key_exists($key, $properties)) {
        // if ($key === 'images') {
        // foreach ($property as $image) {
        // $images = $this->getCurrentProductImages($productEntity);
        
        // if (! in_array($image->location, $images)) {
        // $productImageEntity = new ProductImage();
        // $productImageEntity->setProduct($productEntity)->setName($image->location);
        
        // $productEntity->addProductImage($productImageEntity);
        // }
        // }
        // } else {
        // $propertyEntity = $properties[$key];
        
        // if ($propertyEntity->getValue() !== $property) {
        // $changelogProduct = new ChangelogProduct();
        // $changelogProduct->setName($key)
        // ->setValue($property)
        // ->setProduct($productEntity)
        // ->setCreationDate(new \Datetime());
        
        // $this->entityManager->persist($changelogProduct);
        
        // $propertyEntity->setValue($property);
        // }
        // }
        // } else {
        // $productEntity = $this->entityManager->merge($productEntity);
        
        // $propertyEntity = new \Application\Entity\Property();
        // $propertyEntity->setProduct($productEntity)
        // ->setName($key)
        // ->setValue($property);
        
        // $productEntity->addProperty($propertyEntity);
        // }
        // }
        
        // $this->entityManager->flush();
        // $this->entityManager->clear();
        
        // die();
    }

    private function compareFeedCategories($currentCategories, $categories)
    {
        // $differences = array_merge(array_diff($categories, $currentCategories), array_diff($currentCategories, $categories));
        // if (empty($differences)) {
        // // no differences
        // } else {
        // // there are differences!;
        // }
    }

    private function insertFeedCategory($feed, $categories)
    {
        try {
            $feedCategory = new FeedCategory();
            $feedCategory->setFeed($feed);
            
            $this->entityManager->persist($feedCategory);
            
            foreach ($categories as $category) {
                $feedCategoryValue = new FeedCategoryValue();
                $feedCategoryValue->setName($category)->setFeedCategory($feedCategory);
                
                $this->entityManager->persist($feedCategoryValue);
            }
            
            $this->entityManager->flush();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            die();
        }
        
        // try {
        // $this->entityManager->flush();
        // } catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e) {
        // // Do nothing..
        // }
        // $this->entityManager->clear();
    }

    private function deleteFeedCategory()
    {}
}
