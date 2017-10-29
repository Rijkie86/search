<?php
namespace Application\Service;

use Application\Entity\Bolt;

class BoltService
{

    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findBy(array $properties)
    {
        return $this->entityManager->getRepository('Application\Entity\Bolt')->findBy($properties);
    }

    public function findOneBy(array $properties)
    {
        return $this->entityManager->getRepository('Application\Entity\Bolt')->findOneBy($properties);
    }

    public function findAll()
    {
        return $this->entityManager->getRepository('Application\Entity\Bolt')->findAll();
    }
    
    public function findBoltSize(array $properties)
    {
        return $this->entityManager->getRepository('Application\Entity\BoltSize')->findOneBy($properties);
    }

    public function exists($boltId)
    {}

    public function create(\Application\Entity\Bolt $bolt)
    {
        try {
            $this->entityManager->persist($bolt);
            $this->entityManager->flush($bolt);
        } catch (\Exception $e) {
            var_dump($e->getMessage());die;
            return 'A duplicate category with this name has been found, please choose something else.';
        }
        
        return true;
    }

    public function edit(\Application\Entity\Bolt $bolt)
    {
        try {
            $this->entityManager->flush();
        } catch (\Exception $e) {
            var_dump($e->getMessage());die;
        }
    }

    public function delete()
    {}
}