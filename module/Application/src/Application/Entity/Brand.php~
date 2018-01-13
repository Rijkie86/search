<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Brand
 *
 * @ORM\Table(name="brand")
 * @ORM\Entity
 */
class Brand
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var string @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     *
     * @var string @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     *
     * @var string @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     *
     * @var \Doctrine\Common\Collections\Collection @ORM\ManyToMany(targetEntity="Product", mappedBy="brand")
     */
    private $product;

    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name            
     *
     * @return Brand
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set image
     *
     * @param string $image            
     *
     * @return Brand
     */
    public function setImage($image)
    {
        $this->image = $image;
        
        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set url
     *
     * @param string $url            
     *
     * @return Brand
     */
    public function setUrl($url)
    {
        $this->url = $url;
        
        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Add product
     *
     * @param \Application\Entity\Product $product
     *
     * @return Brand
     */
    public function addProduct(\Application\Entity\Product $product)
    {
        $this->product[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \Application\Entity\Product $product
     */
    public function removeProduct(\Application\Entity\Product $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduct()
    {
        return $this->product;
    }
}
