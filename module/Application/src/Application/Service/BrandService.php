<?php
namespace Application\Service;

use Application\Entity\Brand;

class BrandService
{

    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findBy(array $properties)
    {
        return $this->entityManager->getRepository('Application\Entity\Brand')->findBy($properties);
    }

    public function findOneBy(array $properties)
    {
        return $this->entityManager->getRepository('Application\Entity\Brand')->findOneBy($properties);
    }

    public function findAll()
    {
        return $this->entityManager->getRepository('Application\Entity\Brand')->findAll();
    }

    public function exists($brandId)
    {}

    public function create(\Application\Entity\Brand $brand)
    {
        try {
            $this->entityManager->persist($brand);
            $this->entityManager->flush($brand);
        } catch (\Exception $e) {
            \Doctrine\Common\Util\Debug::dump($e->getMessage());
            die();
        }
        
        return true;
    }

    public function edit(\Application\Entity\Brand $brand)
    {
        try {
            $this->entityManager->flush();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            die();
        }
    }

    public function delete()
    {}
}