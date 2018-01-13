<?php
namespace Application\Service;

use Application\Entity\User;

class AccountService
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
        return $this->entityManager->getRepository('Application\Entity\User')->findAll();
    }

    public function create(\Application\Entity\User $user)
    {
        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush($user);
        } catch (\Exception $e) {
            \Doctrine\Common\Util\Debug::dump($e);
            die();
        }
        
        return true;
    }

    public function update(Application\Entity\Website $user)
    {
        try {
            $this->entityManager->flush($user);
        } catch (\Exception $e) {}
    }

    public function delete()
    {}
}