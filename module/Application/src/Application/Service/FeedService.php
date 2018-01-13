<?php
namespace Application\Service;

use Application\Entity\Feed;
use Application\Entity\FeedCategory;
use Application\Entity\FeedCategoryValue;
use Doctrine\Common\Collections\Criteria;
use Zend\Permissions\Acl\Resource\ResourceInterface;

class FeedService implements ResourceInterface
{

    private $feedCategoryValueService;

    private $entityManager;

    private $categories = [
        'category',
        'category_path'
    ];

    public function __construct($feedCategoryValueService, $entityManager, $authorize)
    {
        $this->feedCategoryValueService = $feedCategoryValueService;
        $this->entityManager = $entityManager;
        $this->authorize = $authorize;
    }

    public function getResourceId()
    {
        return 'feed';
    }

    public function findBy(array $properties)
    {
        $this->authorize->isAllowed($this, 'feed-view');
        
        // return $this->entityManager->getRepository('Application\Entity\Category')->findBy($properties);
    }

    public function findOneBy(array $properties)
    {
        $this->authorize->isAllowed($this, 'feed-view');
        
        return $this->entityManager->getRepository('Application\Entity\Feed')->findOneBy($properties);
    }

    public function findAll()
    {
        $this->authorize->isAllowed($this, 'feed-view');
        
        return $this->entityManager->getRepository('Application\Entity\Feed')->findAll();
    }

    public function exists($feedId, $category)
    {
        $feedCategory = $this->entityManager->getRepository('Application\Entity\FeedCategory')->findOneBy([
            'feed' => $feedId
        ]);
        
        $feedCategoryValue = $feedCategory->getFeedCategoryValue();
        
        $criteria = Criteria::create()->where(Criteria::expr()->eq('name', $category));
        
        if ($feedCategoryValue->matching($criteria)->count() > 0) {
            return true;
        }
        
        return false;
    }

    public function hasFeedCategory()
    {}

    public function create(\Application\Entity\Feed $feed)
    {
        $this->authorize->isAllowed($this, 'feed-create');
        
        try {
            $feedCategory = new FeedCategory();
            $feedCategory->setFeed($feed);
            
            $feed->setFeedCategory($feedCategory);
            
            $this->entityManager->persist($feed);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            die();
        }
        
        return true;
    }

    public function update(\Application\Entity\Feed $feed)
    {
        try {
            $this->entityManager->flush($feed);
        } catch (\Exception $e) {
            \Doctrine\Common\Util\Debug::dump($e);
            die();
        }
    }
    
    public function updateFeedProductProperty(\Application\Entity\FeedProductProperty $feedProductProperty)
    {
        try {
            $this->entityManager->flush($feedProductProperty);
        } catch (\Exception $e) {
            \Doctrine\Common\Util\Debug::dump($e);
            die();
        }
    }

    public function delete(\Application\Entity\Feed $feed)
    {
        try {
            $this->entityManager->remove($feed);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            die();
        }
    }

    public function deleteAll(array $feeds)
    {
        foreach ($feeds as $feed) {
            $this->delete($feed);
        }
    }

    public function getProductProperties($productNode)
    {
        $productProperties = [];
        
        foreach ($productNode->product_info->children() as $item) {
            /**
             *
             * @todo : Images are skipped in this array, find a better solution.
             */
            if (in_array($item->getName(), [
                'images',
                'category',
                'category_path'
            ])) {
                continue;
            }
            
            $productProperties[$item->getName()] = (string) $item;
        }
        
        return $productProperties;
    }

    public function getProductImages($productNode)
    {
        $productImages = [];
        
        foreach ($productNode->product_info->children() as $item) {
            if ($item->getName() === 'images') {
                if ($item->count() > 0) {
                    foreach ($item->image as $image) {
                        $productImages[] = $image;
                    }
                }
            }
        }
        
        return $productImages;
    }

    public function getProductCategories($productNode)
    {
        $productCategories = [];
        
        foreach ($productNode->product_info->children() as $item) {
            if (in_array($item->getName(), $this->categories) && ! in_array((string) $item, $productCategories)) {
                $productCategories[] = (string) $item;
            }
        }
        
        return $productCategories;
    }

    public function getColumns($id)
    {
        $listObject = $this->entityManager->find('Application\Entity\ListObject', $id);
        
        $entityName = preg_replace_callback("/(?:^|_)([a-z])/", function ($matches) {
            return strtoupper($matches[1]);
        }, $listObject->getName());
        
        $schemaManager = $this->entityManager->getConnection()->getSchemaManager();
        
        $foreignKeys = $schemaManager->listTableForeignKeys($listObject->getName());
        
        $columns = [];
        foreach ($foreignKeys as $keys) {
            foreach ($keys->getLocalColumns() as $localColumn) {
                $columns[] = $localColumn;
            }
        }
        
        $valueOptions = [];
        foreach ($schemaManager->listTableColumns($listObject->getName()) as $column) {
            if (! $this->entityManager->getClassMetadata('Application\Entity\\' . $entityName)->isIdentifier($column->getName())) {
                if (array_search($column->getName(), $columns) !== 0) {
                    $valueOptions[$column->getName()] = $column->getName();
                }
            }
        }
        
        return $valueOptions;
    }

    public function updateLastRun($feedId, $datetime)
    {
        $feed = $this->findOneBy([
            'id' => $feedId
        ]);
        $feed->setLastRun($datetime);
        
        $this->entityManager->flush($feed);
    }
}