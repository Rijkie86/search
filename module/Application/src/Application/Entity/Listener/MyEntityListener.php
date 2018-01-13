<?php
namespace Application\Entity\Listener;

use Doctrine\Common\Collections\Criteria;
use Application\Entity\Property;

class MyEntityListener
{

    private $processed = false;

    private $a = [];

    private $brandService;

    public function __construct($o)
    {
        $serviceLocator = $o->getServiceLocator();
        
        $this->brandService = $serviceLocator->get('brandService');
    }

    public function onFlush(\Doctrine\ORM\Event\OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $unitOfWork = $em->getUnitOfWork();
        
        foreach ($unitOfWork->getScheduledEntityInsertions() as $entity) {
            echo 'getScheduledEntityInsertions: ' . PHP_EOL;
            
            $this->process($entity, 'insert');
        }
        
        foreach ($unitOfWork->getScheduledEntityUpdates() as $entity) {
            echo 'getScheduledEntityUpdates: ' . PHP_EOL;
        }
        
        foreach ($unitOfWork->getScheduledEntityDeletions() as $entity) {
            echo 'getScheduledEntityDeletions: ' . PHP_EOL;
            
            $this->process($entity, 'delete');
        }
        
        foreach ($unitOfWork->getScheduledCollectionDeletions() as $col) {
            echo 'getScheduledCollectionDeletions: ' . PHP_EOL;
        }
        
        foreach ($unitOfWork->getScheduledCollectionUpdates() as $col) {
            echo 'getScheduledCollectionUpdates: ' . PHP_EOL;
        }
        
        if ($this->processed == true) {
            
            $collection = new \Doctrine\Common\Collections\ArrayCollection();
            
            foreach ($this->a as $namespace => $properties) {
                if($namespace instanceof \Application\Entity\Brand) {
                    $object = new $namespace();
                    
                    $entities = [];
    
                    foreach ($properties['properties'] as $property) {
                        $entities[] = $property['entity'];
                        $setter = 'set' . $property['property'];
    
                        $object->$setter($property['value']);
                    }
                    
                    $collection->add($object);
                }
                
//                 $em->persist($object);
                
//                 $unitOfWork->computeChangeSet($em->getClassMetadata($namespace), $object);
                
                $savedToProduct = false;
                foreach ($entities as $entity) {
                    if ($savedToProduct == false) {
//                         $entity->getProduct()->setBrand($object);
                        
                        // $unitOfWork->recomputeSingleEntityChangeSet($em->getClassMetadata('Application\Entity\Product'), $entity->getProduct());
                        
                        $savedToProduct = true;
                    }
                    echo 'Remove entity' . PHP_EOL . PHP_EOL;
                    
                    $em->remove($entity);
                }
            }
            
            \Doctrine\Common\Util\Debug::dump($collection, 4);die;
        }
    }

    private function process($entity, $type)
    {
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
                        $newEntityNamespace = 'Application\\Entity\\' . $dbTable;
                        
                        $dbTableProperty = preg_replace_callback("/(?:^|_)([a-z])/", function ($matches) {
                            return strtoupper($matches[1]);
                        }, $feedProductProperty->getDbTableProperty());
                        
                        $this->a['Application\\Entity\\' . $dbTable]['properties'][] = [
                            'entity' => $entity,
                            'type' => $type,
                            'property' => $dbTableProperty,
                            'value' => $entity->getValue()
                        ];
                    }
                }
                
                $this->processed = true;
            }
        }
    }
}