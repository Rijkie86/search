<?php
namespace Application\Service;

use Application\Entity\Category;

class FeedCategoryValueService
{

    private $entityManager;

    private $categoryService;

    public function __construct($entityManager, $categoryService)
    {
        $this->entityManager = $entityManager;
        
        $this->categoryService = $categoryService;
    }

    public function findBy(array $properties)
    {
        return $this->entityManager->getRepository('Application\Entity\FeedCategoryValue')->findBy($properties);
    }

    public function findOneBy(array $properties)
    {
        return $this->entityManager->getRepository('Application\Entity\FeedCategoryValue')->findOneBy($properties);
    }

    public function addToCategories(\Application\Entity\FeedCategoryValue $feedCategoryValue, array $categoryIds)
    {
        $categories = [];
        
        $getAllParentCategories = function ($categoryEntity) use (&$getAllParentCategories, &$categories, &$feedCategoryValue) {
            if (! in_array($categoryEntity->getId(), $categories)) {
                $feedCategoryValue->addCategory($this->entityManager->getReference('Application\Entity\Category', $categoryEntity->getId()));
                $this->entityManager->flush();
            }
            
            $parentEntity = $categoryEntity->getParent();
            if ($parentEntity !== null) {
                $getAllParentCategories($parentEntity);
            }
        };
        
        foreach ($categoryIds as $categoryId) {
            $getAllParentCategories($this->categoryService->findOneBy([
                'id' => $categoryId
            ]));
        }
    }

    public function create(Application\Entity\FeedCategoryValue $feedCategoryValue)
    {
        try {
            $this->entityManager->persist($feedCategoryValue);
            $this->entityManager->flush($feedCategoryValue);
            $this->entityManager->clear();
        } catch (\Exception $e) {
            // Show a nice error message.
        }
        
        return true;
    }
    
    // public function add(Application\Entity\Category $category, $parentId = null)
    // {
    // if($parentId === null) {
    // return false;
    // }
    
    // $category->setName('New node')->setParentId($this->entityManager->getReference('Application\Entity\Category', $parentId));
    
    // $this->create($category);
    // }
    
    // public function edit(Application\Entity\Category $category)
    // {
    // try {
    // $this->entityManager->flush($category);
    // } catch(\Exception $e) {
    
    // }
    // }
}