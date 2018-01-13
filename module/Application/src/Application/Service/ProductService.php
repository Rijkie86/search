<?php
namespace Application\Service;

use Application\Entity\Product;
use Application\Entity\ShellLogProduct;
use Application\Entity\ProductImage;
use Application\Entity\FeedCategoryValue;
use Doctrine\Common\Collections\Criteria;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class ProductService implements \Zend\Permissions\Acl\Resource\ResourceInterface
{

    private $entityManager;

    private $propertyService;

    private $authorize;

    public function __construct($entityManager, $propertyService, $authorize)
    {
        $this->entityManager = $entityManager;
        
        $this->propertyService = $propertyService;
        
        $this->authorize = $authorize;
    }

    public function getResourceId()
    {
        return 'product';
    }

    public function findBy(array $properties, $start = 0, $length = 10)
    {
        return $this->entityManager->getRepository('Application\Entity\Product')->getAllProducts($properties, $start, $length);
    }

    public function findByFeedCategoryValue(array $properties, $start, $length)
    {
        return $this->entityManager->getRepository('Application\Entity\Product')->findByFeedCategoryValue($properties, $start, $length);
    }

    public function findOneBy(array $properties)
    {
        $product = $this->entityManager->getRepository('Application\Entity\Product')->findOneBy($properties);
        
        if (! $this->authorize->isAllowed('product', 'view-product')) {
            throw new \Exception('Insufficient privileges to complete the operation.');
        }
        
        /**
         *
         * @todo : Move to ACL
         */
        if (php_sapi_name() != "cli") {
            if ($product !== null) {
                if ($product->getStatus() == 0) {
                    throw new \Exception('Product cannot be edited at this time');
                }
            }
        }
        
        return $product;
    }

    public function findAll()
    {
        // return $this->entityManager->getRepository('Application\Entity\Feed')->findAll();
    }

    public function exists()
    {}

    public function create(\Application\Entity\Product $product)
    {
        /**
         *
         * @todo : Use the full entity for 'created_by' instead of the id.
         */
        try {
            if (php_sapi_name() == "cli") {
                $product->setCreatedBy(3);
                // $product->setCreatedBy($this->entityManager->find('Application\Entity\User', 3));
            } else {
                $product->setCreatedBy(1);
                // $product->setCreatedBy($this->entityManager->find('Application\Entity\User', 1));
            }
            
            $product->setCreationDate(new \DateTime());
            
            $this->entityManager->persist($product);
            $this->entityManager->flush($product);
            $this->entityManager->clear();
            
            $params = [
                'index' => 'productsearch',
                'body' => [
                    'mappings' => [
                        'product' => [
                            '_source' => [
                                'enabled' => true
                            ],
                            'properties' => [
                                'suggest' => [
                                    'type' => 'completion',
                                    'analyzer' => 'standard'
                                ],
                                'name' => [
                                    'type' => 'keyword'
                                ]
                            ]
                        ]
                    ]
                ]
            ];
            
            $client = \Elasticsearch\ClientBuilder::create()->setHosts([
                '149.210.204.168:9200'
            ])->build();
            
            if (! $client->indices()->exists([
                'index' => 'productsearch'
            ])) {
                $client->indices()->create($params);
            }
            
            $document = [
                'index' => 'productsearch',
                'type' => 'product',
                'id' => $product->getId(),
                'body' => [
                    'suggest' => [
                        'input' => [
                            (string) $product->getId(),
                            $product->getName()
                        ]
                    ]
                ]
            ];
            
            $response = $client->index($document);
            
            // \Doctrine\Common\Util\Debug::dump($response);
            
            return $product->getId();
        } catch (\Exception $e) {
            // return 'A duplicate category with this name has been found, please choose something else.';
            \Doctrine\Common\Util\Debug::dump($e);
            die();
        }
        
        return true;
    }

    public function edit(\Application\Entity\Product $product)
    {
        /**
         *
         * @todo : Use the full entity for 'modified_by' instead of the id.
         */
        try {
            if (php_sapi_name() == "cli") {
                $product->setModifiedBy(3);
                // $product->setModifiedBy($this->entityManager->find('Application\Entity\User', 3));
            } else {
                $product->setModifiedBy(1);
                // $product->setModifiedBy($this->entityManager->find('Application\Entity\User', 1));
            }
            
            $product->setModifiedDate(new \DateTime());
            
            $this->entityManager->flush();
            $this->entityManager->clear();
            
            $params = [
                'index' => 'productsearch',
                'body' => [
                    'mappings' => [
                        'product' => [
                            '_source' => [
                                'enabled' => true
                            ],
                            'properties' => [
                                'suggest' => [
                                    'type' => 'completion',
                                    'analyzer' => 'standard'
                                ],
                                'name' => [
                                    'type' => 'keyword'
                                ]
                            ]
                        ]
                    ]
                ]
            ];
            
            $client = \Elasticsearch\ClientBuilder::create()->setHosts([
                '149.210.204.168:9200'
            ])->build();
            
            if (! $client->indices()->exists([
                'index' => 'productsearch'
            ])) {
                $client->indices()->create($params);
            }
            
            if ($client->exists([
                'index' => 'productsearch',
                'type' => 'product',
                'id' => $product->getId()
            ])) {
                $document = [
                    'index' => 'productsearch',
                    'type' => 'product',
                    'id' => $product->getId(),
                    'body' => [
                        'doc' => [
                            'suggest' => [
                                'input' => [
                                    (string) $product->getId(),
                                    $product->getName()
                                ]
                            ]
                        ]
                    ]
                ];
                
                $response = $client->update($document);
                
                if (! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {} else {
                    // \Doctrine\Common\Util\Debug::dump($response);
                }
            } else {
                $document = [
                    'index' => 'productsearch',
                    'type' => 'product',
                    'id' => $product->getId(),
                    'body' => [
                        'name' => $product->getName()
                    ]
                ];
                
                $response = $client->index($document);
                
                // \Doctrine\Common\Util\Debug::dump($response);
            }
        } catch (\Exception $e) {
            \Doctrine\Common\Util\Debug::dump($e);
            die();
        }
    }

    public function updateProperties(\Application\Entity\Product $product, array $properties)
    {
        if ($this->entityManager->contains($product) === false) {
            $product = $this->entityManager->merge($product);
        }
        
        if (empty($properties)) {
            return false;
        }
        
        if (false !== ($product = $this->propertyService->updateProperties($product, $properties))) {
            
            echo 'Properties updated' . PHP_EOL . PHP_EOL;
            
            $this->edit($product);
        }
    }

    public function updateMedia(\Application\Entity\Product $product, $id, $name, $value)
    {
        if (! $this->authorize->isAllowed('product', 'update-media')) {
            throw new \Exception('Insufficient privileges to complete the operation.');
        }
        
        $productImage = $product->getProductImage();
        
        $criteria = Criteria::create();
        $criteria->andWhere(Criteria::expr()->eq('id', $id));
        
        if ($productImage->matching($criteria)->count() == 1) {
            
            $setter = 'set' . ucfirst($name);
            
            $productImage->matching($criteria)
                ->first()
                ->$setter($value);
        }
        
        $this->edit($product);
        
        return [
            'id' => $product->getId()
        ];
    }

    public function updateSeo(\Application\Entity\Product $product, $id, $name, $value)
    {
        if (! $this->authorize->isAllowed('product', 'update-seo')) {
            throw new \Exception('Insufficient privileges to complete the operation.');
        }
        
        $setter = 'set' . ucfirst($name);
        
        $product->$setter($value);
        
        $this->edit($product);
        
        return [
            'id' => $product->getId()
        ];
    }

    public function updateImages(\Application\Entity\Product $product, $images)
    {
        if (empty($images) || ! is_array($images)) {
            return;
        }
        
        if ($this->entityManager->contains($product) === false) {
            $product = $this->entityManager->merge($product);
        }
        
        $productImageCollection = $product->getProductImage();
        
        foreach ($images as $key => $value) {
            $imageExists = $productImageCollection->exists(function ($Hanneke, $element) use ($key) {
                if ($key == $element->getName()) {
                    return true;
                }
            });
            
            /*
             * @todo: Remove images that are not being used anymore
             */
            
            if ($imageExists === false) {
                $productImage = new ProductImage();
                $productImage->setName((string) $value->location)->setProduct($product);
                
                $product->addProductImage($productImage);
                
                $this->edit($product);
            }
        }
    }

    public function updateCategories(\Application\Entity\Product $product, $categories)
    {
        var_dump($categories);
        \Doctrine\Common\Util\Debug::dump($product->getFeedCategoryValue());
        
        if (empty($categories) || ! is_array($categories)) {
            return;
        }
        
        if ($this->entityManager->contains($product) === false) {
            $product = $this->entityManager->merge($product);
        }
        
        $query = $this->entityManager->createQuery("SELECT feedCategoryValue FROM Application\Entity\FeedCategoryValue feedCategoryValue WHERE feedCategoryValue.feedCategory = :feedCategoryId");
        $query->setParameters([
            'feedCategoryId' => $product->getFeed()
                ->getFeedCategory()
        ]);
        
        $results = $query->getArrayResult();
        
        $categories = array_map('htmlspecialchars', $categories);
        
        $currentValues = [];
        foreach ($results as $key => $values) {
            $currentValues[] = htmlspecialchars($values['name']);
        }
        
        $count = count($categories);
        if (count(array_intersect($categories, $currentValues)) != $count) {
            $differences = array_merge(array_diff(array_intersect($categories, $currentValues), $categories), array_diff($categories, array_intersect($categories, $currentValues)));
            
            foreach ($differences as $difference) {
                $feedCategoryValue = new FeedCategoryValue();
                $feedCategoryValue->setName($difference)->setFeedCategory($product->getFeed()
                    ->getFeedCategory());
                
                $product->addFeedCategoryValue($feedCategoryValue);
            }
            
            $this->edit($product);
        }
    }

    public function delete()
    {}

    public function reset()
    {
        $this->entityManager->getRepository('Application\Entity\Product')->reset();
    }
}