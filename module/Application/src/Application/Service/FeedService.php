<?php
namespace Application\Service;

use Application\Entity\Feed;
use Application\Entity\FeedCategory;
use Application\Entity\FeedCategoryValue;
use Doctrine\Common\Collections\Criteria;

class FeedService
{

    private $entityManager;

    private $categories = [
        'category',
        'category_path'
    ];

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findBy(array $properties)
    {
        // return $this->entityManager->getRepository('Application\Entity\Category')->findBy($properties);
    }

    public function findOneBy(array $properties)
    {
        return $this->entityManager->getRepository('Application\Entity\Feed')->findOneBy($properties);
    }

    public function findAll()
    {
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

    public function addFeedCategoryValue($feedId, $categoryName)
    {
        echo $categoryName . PHP_EOL;
        if (empty($categoryName)) {
            return false;
        }
        
        $feedCategory = $this->entityManager->getRepository('Application\Entity\FeedCategory')->findOneBy([
            'feed' => $feedId
        ]);
        
        $feedCategoryValue = new FeedCategoryValue();
        $feedCategoryValue->setName($categoryName)->setFeedCategory($feedCategory);
        
        $feedCategory->addFeedCategoryValue($feedCategoryValue);
        
        try {
            $this->entityManager->flush();
            $this->entityManager->clear();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            die();
        }
    }

    public function create(\Application\Entity\Feed $feed)
    {
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

    public function edit(\Application\Entity\Feed $feed)
    {
        try {
            $this->entityManager->flush($feed);
        } catch (\Exception $e) {}
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
            if (count($item) > 0) {
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
}