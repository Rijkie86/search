<?php
namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CategoryRepository extends EntityRepository
{

    public function getCategoriesWithOptgroups()
    {
        return $this->_em->createQuery("SELECT Category FROM Application\Entity\Category Category")->getResult();
    }

    public function getFeedCategoryValues($start, $length)
    {
      $queryBuilder = $this->_em->createQueryBuilder();
      $queryBuilder->select('feedCategoryValue', 'category')
        ->from('Application\Entity\FeedCategoryValue', 'feedCategoryValue')
        ->leftJoin('feedCategoryValue.category', 'category')
        ->having('COUNT(category.id) = 0')
        ->groupBy('feedCategoryValue.id')
        ->setFirstResult($start)
        ->setMaxResults($length);

      $query = $queryBuilder->getQuery();

      $paginator = new paginator($query);

      return $paginator;
    }
}
