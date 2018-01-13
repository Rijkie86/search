<?php
namespace Application\Entity\Listener;

use Application\Entity\Property;
use Application\Entity\FeedProductProperty;
use Doctrine\Common\Collections\Criteria;
use Application\Entity\Brand;

class PropertyListener
{

    private $processed = false;

    private $a = [];

    public function postPersist(\Application\Entity\Property $property, \Doctrine\ORM\Event\LifecycleEventArgs $args)
    {
        $entityManager = $args->getEntityManager();
        
//         $this->process($property, 'insert');
        
        if ($this->processed == true) {
            foreach ($this->a as $namespace => $data) {
                $properties = $data['properties'];
                
                if ($namespace == 'Application\Entity\Brand') {
                    
                    $setter = 'set' . $properties['property'];
                    
                    if ($property->getProduct()
                        ->getBrand()
                        ->count() < 1) {
                        $object = new $namespace();
                        $object->$setter($properties['value']);
                        
                        $entityManager->persist($object);
                        $property->getProduct()->addBrand($object);
                        
                        $entityManager->flush($property->getProduct());
                    } else {
                        $brand = $property->getProduct()->getBrand();
                        $brand[0]->$setter($properties['value']);
                        
                        $entityManager->flush($brand[0]);
                    }
                }

                $entityManager->remove($properties['entity']);
                $entityManager->flush();
            }
        }
    }

    private function process($entity, $type)
    {
        $feedProductPropertyCollection = $entity->getProduct()
            ->getFeed()
            ->getFeedProductProperty();
        
        $criteria = Criteria::create()->where(Criteria::expr()->eq('name', $entity->getName()));
        
        if ($feedProductPropertyCollection->matching($criteria)->count() > 0) {
            foreach ($feedProductPropertyCollection->matching($criteria) as $feedProductProperty) {
                $dbTable = preg_replace_callback("/(?:^|_)([a-z])/", function ($matches) {
                    return strtoupper($matches[1]);
                }, $feedProductProperty->getDbTable());
                
                $dbTableProperty = preg_replace_callback("/(?:^|_)([a-z])/", function ($matches) {
                    return strtoupper($matches[1]);
                }, $feedProductProperty->getDbTableProperty());
                
                if (! empty($dbTable) && ! empty($dbTableProperty)) {
                    $newEntityNamespace = 'Application\\Entity\\' . $dbTable;
                    
                    $this->a[$newEntityNamespace]['properties'] = [
                        'entity' => $entity,
                        'type' => $type,
                        'property' => $dbTableProperty,
                        'value' => $entity->getValue()
                    ];
                    
                    $this->processed = true;
                }
            }
        }
    }
}