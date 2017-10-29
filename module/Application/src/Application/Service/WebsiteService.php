<?php
namespace Application\Service;

use Application\Entity\Category;

class WebsiteService
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
        return $this->entityManager->getRepository('Application\Entity\Website')->findAll();
    }

    public function create(\Application\Entity\Website $website)
    {
        try {
            $this->entityManager->persist($website);
            $this->entityManager->flush($website);
        } catch(\Exception $e) {
            return 'A duplicate category with this name has been found, please choose something else.';
        }
            
        return true;
    }
    
    public function add(\Application\Entity\Website $website)
    {
//         if($parentId === null) {
//             return false;
//         }
        
//         $category->setName('New node')->setParentId($this->entityManager->getReference('Application\Entity\Category', $parentId));
        
//         $this->create($category);
    }
    
    public function edit(Application\Entity\Website $website)
    {
        try {
            $this->entityManager->flush($website);
        } catch(\Exception $e) {
            
        }
    }
    
    public function delete()
    {
        
    }
}