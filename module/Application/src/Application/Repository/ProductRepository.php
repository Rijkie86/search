<?php
namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ProductRepository extends EntityRepository
{

    public function getAllProducts($params)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select('product')
            ->from('Application\Entity\Product', 'product')
            ->setFirstResult($params->fromPost('start', 0))
            ->setMaxResults($params->fromPost('length', 0));
        
        $query = $queryBuilder->getQuery();
        
        $paginator = new paginator($query);
        
        return $paginator;
    }
}
