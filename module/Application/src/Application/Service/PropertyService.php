<?php
namespace Application\Service;

use Application\Entity\Product;
use Application\Entity\Property;
use Application\Entity\Brand;
use Application\Entity\Accommodation;

class PropertyService
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
        // return $this->entityManager->getRepository('Application\Entity\Product')->findOneBy($properties);
    }

    public function findAll()
    {
        // return $this->entityManager->getRepository('Application\Entity\Feed')->findAll();
    }

    public function exists()
    {}

    public function create(\Application\Entity\Property $property)
    {
        try {
            $this->entityManager->persist($property);
            $this->entityManager->flush($property);
        } catch (\Exception $e) {
            return 'A duplicate category with this name has been found, please choose something else.';
        }
        
        return true;
    }

    public function edit(\Application\Entity\Product $product)
    {
        // $batchSize = $product->getProperty()->count();
        // $i = 1;
        
        // $properties = $product->getProperty();
        
        // try {
        // $query = $this->entityManager->createQuery('SELECT p FROM Application\Entity\Property p WHERE p.id IN(' . implode(',', $propertyIds) . ')');
        // $iterableResult = $query->iterate();
        
        // $properties = [];
        
        // foreach ($properties as $row) {
        // $properties[] = $row[0];
        
        // if (($i % $batchSize) === 0) {
        
        // // \Doctrine\Common\Util\Debug::dump($properties);
        
        // $this->entityManager->flush($properties);
        // // $this->entityManager->clear();
        // }
        // ++ $i;
        // }
        
        // // $this->entityManager->flush();
        // } catch (\Exception $e) {
        // var_dump($e->getMessage());
        // die();
        // }
    }

    public function exclude($property, \Doctrine\ORM\PersistentCollection $feedProductProperty)
    {
        foreach ($feedProductProperty as $entity) {
            if ($entity->getActive() == false) {
                continue;
            }

            if ($entity->getListObject() !== null) {
                if ((string) $property === (string) $entity->getName()) {
                    return $entity;
                }
            }
        }

        return false;
    }

    public function updateProperty(\Application\Entity\Property $property, $value)
    {
        $property->setValue($value);
        
        $this->entityManager->flush($property);
    }

    public function updateProperties(\Application\Entity\Product $product, array $data)
    {
        $feedProductPropertyCollection = $product->getFeed()->getFeedProductProperty();
        
        $property = null;
        
        $changed = false;
        
        $properties = $product->getProperty();
        
        foreach ($data as $key => $value) {
            if (false === ($entity = $this->exclude($key, $feedProductPropertyCollection))) {} else {
                if (in_array($key, [
                    'brand',
                    'brand_logo'
                ])) {
                    $setter = 'set' . ucfirst($entity->getDbTableProperty());
                    
                    if ($product->getBrand()->count() < 1) {
                        $brand = new Brand();
                        $brand->$setter($value);
                        
                        $product->addBrand($brand);
                    } else {
                        $brand = $product->getBrand()->first();
                        $brand->$setter($value);
                    }
                    
                    $matchedProperty = true;
                } elseif (in_array($key, [
                    'latitude',
                    'longitude'
                ])) {
                    $setter = 'set' . ucfirst($entity->getDbTableProperty());
                    
                    if ($product->getAccommodation()->count() < 1) {
                        $accommodation = new Accommodation();
                        $accommodation->$setter($value);
                        
                        $product->addAccommodation($accommodation);
                    } else {
                        $accommodation = $product->getAccommodation()->first();
                        $accommodation->$setter($value);
                    }
                    
                    $matchedProperty = true;
                } elseif ($key == 'link') {
                    $setter = 'set' . ucfirst($entity->getDbTableProperty());
                    
                    $product->$setter($value);
                    
                    $matchedProperty = true;
                } elseif ($key == 'description') {
                    $setter = 'set' . ucfirst($entity->getDbTableProperty());
                    
                    $product->$setter($value);
                    
                    $matchedProperty = true;
                } elseif ($key == 'title') {
                    $setter = 'set' . ucfirst($entity->getDbTableProperty());
                    
                    $product->$setter($value);
                    
                    $matchedProperty = true;
                } elseif ($key == 'price') {
                    $setter = 'set' . ucfirst($entity->getDbTableProperty());
                    
                    $product->$setter($value);
                    
                    $matchedProperty = true;
                }
                
                $changed = true;
            }
        }
        
        if ($changed === true) {
            return $product;
        }
        
        return false;
    }

    public function delete()
    {}
}