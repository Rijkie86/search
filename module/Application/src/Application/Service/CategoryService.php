<?php
namespace Application\Service;

use Application\Entity\Category;

class CategoryService
{
    private $entityManager;
    
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function findBy(array $properties)
    {
        return $this->entityManager->getRepository('Application\Entity\Category')->findBy($properties);
    }
    
    public function findOneBy(array $properties)
    {
        return $this->entityManager->getRepository('Application\Entity\Category')->findOneBy($properties);
    }
    
    public function findAll()
    {
//         $this->entityManager->find
    }
    
    public function exists($categoryId)
    {
        
    }
    
    public function create(\Application\Entity\Category $category)
    {
        try {
            $this->entityManager->persist($category);
            $this->entityManager->flush($category);
        } catch(\Exception $e) {
            var_dump($e->getMessage());die;
            return 'A duplicate category with this name has been found, please choose something else.';
        }
            
        return true;
    }
    
    public function add(\Application\Entity\Category $category, $parentId = null)
    {
        if($parentId === null) {
            return false;
        }
        
        $category->setName('New node')->setParent($this->entityManager->getReference('Application\Entity\Category', $parentId));
        
        $this->create($category);
    }
    
    public function edit(\Application\Entity\Category $category)
    {
        try {
            $this->entityManager->flush($category);
        } catch(\Exception $e) {
            var_dump($e->getMessage());
        }
    }
    
    public function delete()
    {
        
    }
    
    public function rename($nodeData)
    {
        $category = $this->entityManager->find('Application\Entity\Category', $nodeData['id']);
        $category->setName($nodeData['text']);
        
        $this->edit($category);
    }
    
    public function getUnassignedFeedCategoryValues($start = 0, $length = 10)
    {
        return $this->entityManager->getRepository('Application\Entity\Category')->getFeedCategoryValues($start, $length);
    }
}