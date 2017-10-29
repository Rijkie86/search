<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductImage
 *
 * @ORM\Table(name="product_image", indexes={@ORM\Index(name="IDX_64617F034584665A", columns={"product_id"})})
 * @ORM\Entity
 */
class ProductImage
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
     * @var string @ORM\Column(name="alt", type="string", length=255, nullable=true)
     */
    private $alt;

    /**
     *
     * @var string @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     *
     * @var \Application\Entity\Product @ORM\ManyToOne(targetEntity="Application\Entity\Product")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     *      })
     */
    private $product;

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
     * @return ProductImage
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
     * Set alt
     *
     * @param string $alt            
     *
     * @return ProductImage
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
        
        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set title
     *
     * @param string $title            
     *
     * @return ProductImage
     */
    public function setTitle($title)
    {
        $this->title = $title;
        
        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set product
     *
     * @param \Application\Entity\Product $product            
     *
     * @return ProductImage
     */
    public function setProduct(\Application\Entity\Product $product = null)
    {
        $this->product = $product;
        
        return $this;
    }

    /**
     * Get product
     *
     * @return \Application\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
