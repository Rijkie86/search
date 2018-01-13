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
    
    public function findFeedCategoryValue($feedCategoryId, $value)
    {
        $query = $this->_em->createQuery("SELECT feedCategoryValue FROM Application\Entity\FeedCategoryValue feedCategoryValue WHERE feedCategoryValue.feedCategory = :feedCategoryId AND feedCategoryValue.name = :value");
        $query->setParameters(['feedCategoryId' => $feedCategoryId, 'value' => $value]);

        return $query->getOneOrNullResult();
    }

    public function getFeedCategoryValues($filter)
    {
        $orderField = $filter['columns'][key($filter['order'])]['name'];
        $orderDirection = $filter['order'][key($filter['order'])]['dir'];
        
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select('feedCategoryValue', 'category')
            ->from('Application\Entity\FeedCategoryValue', 'feedCategoryValue')
            ->leftJoin('feedCategoryValue.category', 'category')
            ->having('COUNT(category.id) = 0')
            ->orderBy('feedCategoryValue.' . $orderField, $orderDirection)
            ->groupBy('feedCategoryValue.id')
            ->setFirstResult($filter['start'])
            ->setMaxResults($filter['length']);
        
        if (! empty($filter['search']['value'])) {
            $queryBuilder->where($queryBuilder->expr()
                ->like('feedCategoryValue.name', $queryBuilder->expr()
                ->literal('%' . $filter['search']['value'] . '%')));
        }
        
        $query = $queryBuilder->getQuery();

        $paginator = new paginator($query);
        
        return $paginator;
    }
}
