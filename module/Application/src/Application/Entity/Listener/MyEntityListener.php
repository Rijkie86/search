<?php
namespace Application\Entity\Listener;

use Doctrine\Common\Collections\Criteria;

class MyEntityListener
{

    public function onFlush(\Doctrine\ORM\Event\OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $unitOfWork = $em->getUnitOfWork();
        
        foreach ($unitOfWork->getScheduledEntityInsertions() as $entity) {}
        
        foreach ($unitOfWork->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof \Application\Entity\Property) {
                $feedProductPropertyCollection = $entity->getProduct()
                    ->getFeed()
                    ->getFeedProductProperty();
                
                $criteria = Criteria::create()->where(Criteria::expr()->eq('name', $entity->getName()));
                
                if ($feedProductPropertyCollection->matching($criteria)->count() > 0) {
                    foreach ($feedProductPropertyCollection->matching($criteria) as $feedProductProperty) {
                        $dbTable = preg_replace_callback("/(?:^|_)([a-z])/", function ($matches) {
                            return strtoupper($matches[1]);
                        }, $feedProductProperty->getDbTable());
                        
                        if (! empty($dbTable)) {
                            $dbTableProperty = 'set' . ucfirst($feedProductProperty->getTbTableProperty());
                            
                            $newEntityNamespace = 'Application\\Entity\\' . $dbTable;
                            
                            $object = new $newEntityNamespace();
                            $object->$dbTableProperty($entity->getValue());
                            
                            $em->persist($object);
                            
                            $unitOfWork->computeChangeSet($em->getClassMetadata($newEntityNamespace), $object);
                            
                            /*
                             * Update foreign key
                             */
                            
                            $entity->getProduct()->setBrand($object);
                            
                            $unitOfWork->recomputeSingleEntityChangeSet($em->getClassMetadata('Application\Entity\Product'), $entity->getProduct());
                            
                            $em->remove($entity);
                        }
                    }
                }
            }
        }
        
        foreach ($unitOfWork->getScheduledEntityDeletions() as $entity) {}
        
        foreach ($unitOfWork->getScheduledCollectionDeletions() as $col) {}
        
        foreach ($unitOfWork->getScheduledCollectionUpdates() as $col) {}
    }
}