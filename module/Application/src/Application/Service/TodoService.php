<?php
namespace Application\Service;

use Application\Entity\Todo;

class TodoService
{

    private $entityManager;

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
        // return $this->entityManager->getRepository('Application\Entity\Category')->findOneBy($properties);
    }

    public function findAll()
    {
        return $this->entityManager->getRepository('Application\Entity\Todo')->findAll();
    }

    public function create(\Application\Entity\Todo $todo)
    {
        try {
            $todo->setCreationDate(new \DateTime());
            
            $this->entityManager->persist($todo);
            $this->entityManager->flush($todo);
        } catch (\Exception $e) {
            \Doctrine\Common\Util\Debug::dump($e);
            die();
        }
        
        return true;
    }

    public function edit(\Application\Entity\Todo $todo)
    {
        try {
            $this->entityManager->flush($todo);
        } catch (\Exception $e) {
            \Doctrine\Common\Util\Debug::dump($e);
            die();
        }
    }

    public function delete()
    {}
}