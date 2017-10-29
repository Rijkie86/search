<?php
namespace Application\Service;

use Application\Entity\Product;
use Application\Entity\Property;
use Application\Entity\ShellLogProduct;

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

    public function edit(\Application\Entity\Property $property)
    {
        try {
            $this->entityManager->flush($property);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            die();
        }
    }

    public function updateProperty(\Application\Entity\Property $property, $value)
    {
        $property->setValue($value);

        $this->entityManager->flush($property);
    }

    public function updateProperties(\Application\Entity\Product $product, array $data)
    {
        $properties = $product->getProperty();
        
        foreach ($data as $key => $value) {
            $propertyExists = $properties->exists(function ($Hanneke, $element) use ($product, $data, $key, $value) {
                if ($key == $element->getName()) {
                    return $element;
                }
            });
            
            if ($propertyExists === false) {
                $property = new Property();
                $property->setName($key)->setValue(trim($value))->setProduct($product);
                
                $this->create($property);
            } else {
                $property = $this->entityManager->getRepository('Application\Entity\Property')->findOneBy([
                    'product' => $product,
                    'name' => $key
                ]);
                $property->setValue($value);
                
                if (php_sapi_name() == "cli") {
                    $shellLogProduct = new ShellLogProduct();
                    $shellLogProduct->setProduct($product);
                    
                    $this->entityManager->persist($shellLogProduct);
                    $this->entityManager->flush($shellLogProduct);
                }
                
                $this->edit($property);
            }
        }
    }

    public function delete()
    {}
}