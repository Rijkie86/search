<?php
namespace Application\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query\ResultSetMapping;

class ProductRepository extends EntityRepository
{

    public function findByFeedCategoryValue(array $properties, $start = 0, $length = 10)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select('product')
            ->from('Application\Entity\Product', 'product')
            ->join('product.feedCategoryValue', 'feedCategoryValue')
            ->where($queryBuilder->expr()
            ->eq('feedCategoryValue.id', $properties['id']))
            ->setFirstResult($start)
            ->setMaxResults($length);
        
        $query = $queryBuilder->getQuery();
        
        $paginator = new paginator($query);
        
        return $paginator;
    }

    public function getAllProducts($params, $start, $length)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select('product')
            ->from('Application\Entity\Product', 'product')
            ->setFirstResult($start)
            ->setMaxResults($length);

        foreach ($params as $key => $values) {
            if ($values['value'] != '') {
                if ($values['name'] === 'price') {
                    $queryBuilder->andWhere($queryBuilder->expr()->lte('product.' . $values['name'], $values['value']));
                } else {
                    $queryBuilder->andWhere('product.' . $values['name'] . ' = ?' . $key);
                    $queryBuilder->setParameter($key, $values['value']);
                }
            }
        }
        
        $query = $queryBuilder->getQuery();
        
        $paginator = new paginator($query);
        
        return $paginator;
    }

    public function reset()
    {
        $connection = $this->getEntityManager()->getConnection();
        
        $this->_em->createQuery('DELETE Application\Entity\Product product')->execute();
        $this->_em->createQuery('DELETE Application\Entity\Brand brand')->execute();
        
        $connection->exec("ALTER TABLE product AUTO_INCREMENT = 1");
        $connection->exec("ALTER TABLE property AUTO_INCREMENT = 1");
        $connection->exec("ALTER TABLE brand AUTO_INCREMENT = 1");
        
        echo str_pad('DELETE FROM `product`', 50) . "\033[32mYES\033[0m\n";
        echo str_pad('DELETE FROM `brand`', 50) . "\033[32mYES\033[0m\n";
        echo str_pad('ALTER TABLE `product` auto_increment = 1', 50) . "\033[32mYES\033[0m\n";
        echo str_pad('ALTER TABLE `property` auto_increment = 1', 50) . "\033[32mYES\033[0m\n";
    }
}
