<?php
namespace Application\Service;

use Application\Entity\Product;
use Application\Entity\ShellLogProduct;
use Application\Entity\ProductImage;

class ProductService
{

    private $entityManager;

    private $propertyService;

    public function __construct($entityManager, $propertyService)
    {
        $this->entityManager = $entityManager;
        
        $this->propertyService = $propertyService;
    }

    public function findBy($properties)
    {
        return $this->entityManager->getRepository('Application\Entity\Product')->getAllProducts($properties);
    }

    public function findOneBy(array $properties)
    {
        $product = $this->entityManager->getRepository('Application\Entity\Product')->findOneBy($properties);
        
        // if($product !== null) {
        // if (php_sapi_name() == "cli") {
        // $shellLogProduct = new ShellLogProduct();
        // $shellLogProduct->setProduct($product);
        
        // $this->entityManager->persist($shellLogProduct);
        // $this->entityManager->flush($shellLogProduct);
        // }
        // }
        
        return $product;
    }

    public function findAll()
    {
        // return $this->entityManager->getRepository('Application\Entity\Feed')->findAll();
    }

    public function exists()
    {}

    public function create(\Application\Entity\Product $product)
    {
        /**
         *
         * @todo : Use the full entity for 'created_by' instead of the id.
         */
        try {
            if (php_sapi_name() == "cli") {
                $product->setCreatedBy(3);
                // $product->setCreatedBy($this->entityManager->find('Application\Entity\User', 3));
            } else {
                $product->setCreatedBy(1);
                // $product->setCreatedBy($this->entityManager->find('Application\Entity\User', 1));
            }
            
            $product->setCreationDate(new \DateTime());
            
            $this->entityManager->persist($product);
            $this->entityManager->flush($product);
            $this->entityManager->clear();
        } catch (\Exception $e) {
            // return 'A duplicate category with this name has been found, please choose something else.';
            var_dump($e->getMessage());
            die();
        }
        
        return true;
    }

    public function createImage(\Application\Entity\ProductImage $productImage)
    {
        $this->entityManager->persist($productImage);
        $this->entityManager->flush($productImage);
        // $this->entityManager->clear();
    }

    public function edit(\Application\Entity\Product $product)
    {
        /**
         *
         * @todo : Use the full entity for 'modified_by' instead of the id.
         */
        try {
            if (php_sapi_name() == "cli") {
                $product->setModifiedBy(3);
                // $product->setModifiedBy($this->entityManager->find('Application\Entity\User', 3));
            } else {
                $product->setModifiedBy(1);
                // $product->setModifiedBy($this->entityManager->find('Application\Entity\User', 1));
            }
            
            $product->setModifiedDate(new \DateTime());
            
            $this->entityManager->flush();
            $this->entityManager->clear();
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            die();
            die('aaaaaaaaaaaaaaaaaaaaaa');
        }
    }

    public function updateProperties(\Application\Entity\Product $product, array $properties)
    {
        if($this->entityManager->contains($product) === false) {
            $product = $this->entityManager->merge($product);
        }

        if (empty($properties)) {
            return false;
        }
        
        $this->propertyService->updateProperties($product, $properties);
        
//         $this->edit($product);
    }

    public function updateImages(\Application\Entity\Product $product, $images)
    {
        if($this->entityManager->contains($product) === false) {
            $product = $this->entityManager->merge($product);
        }

        if (empty($images) || ! is_array($images)) {
            return;
        }
        
        $productImageCollection = $product->getProductImage();
        
        foreach ($images as $key => $value) {
            $imageExists = $productImageCollection->exists(function ($Hanneke, $element) use ($product, $images, $key, $value) {
                if ($key == $element->getName()) {
                    return $element;
                }
            });
            
            /*
             * @todo: Remove images that are not being used anymore
             */
            
            if ($imageExists === false) {
                $productImage = new ProductImage();
                $productImage->setName((string) $value->location)->setProduct($product);
                
                $this->createImage($productImage);
            }
        }
    }

    public function delete()
    {}

    public function clean()
    {
        // echo 'Clean all inactive products';
        
        // $counter = 0;
        // $batchSize = 100;
        
        // $query = $this->entityManager->createQuery('SELECT p FROM Application\Entity\Product p WHERE EXISTS (SELECT s.id FROM Application\Entity\ShellLogProduct s WHERE s.product = p.id) AND p.status = :status');
        // $query->setParameter('status', 'Inactive');
        // foreach ($query->iterate() as $row) {
        // $product = $row[0];
        // $product->setStatus('Active');
        
        // if (($counter % $batchSize) === 0) {
        // $this->entityManager->flush();
        // $this->entityManager->clear();
        // }
        // }
        
        // $this->entityManager->flush();
        // $this->entityManager->clear();
        
        // $query = $this->entityManager->createQuery('SELECT p FROM Application\Entity\Product p WHERE NOT EXISTS (SELECT s.id FROM Application\Entity\ShellLogProduct s WHERE s.product = p.id) AND p.status = :status');
        // $query->setParameter('status', 'Active');
        // foreach ($query->iterate() as $row) {
        // $product = $row[0];
        // $product->setStatus('Inactive');
        
        // if (($counter % $batchSize) === 0) {
        // $this->entityManager->flush();
        // $this->entityManager->clear();
        // }
        // }
        
        // $this->entityManager->flush();
        // $this->entityManager->clear();
    }
}