<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="category_id", columns={"category_id"}), @ORM\Index(name="unique_id", columns={"unique_id"})})
 * @ORM\Entity(repositoryClass="Application\Repository\ProductRepository")
 */
class Product
{

    /**
     *
     * @var int @ORM\Column(name="id", type="integer", nullable=false)
     *      @ORM\Id
     *      @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var string @ORM\Column(name="unique_id", type="string", length=255, nullable=false)
     */
    private $uniqueId;

    /**
     *
     * @var int @ORM\Column(name="program_id", type="integer", nullable=false)
     */
    private $programId;

    /**
     *
     * @var string @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     *
     * @var string @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     *
     * @var string @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     *
     * @var \Application\Entity\ProductImage @ORM\OneToMany(targetEntity="Application\Entity\ProductImage", mappedBy="product", cascade={"persist"})
     */
    private $productImage;

    /**
     *
     * @var \Application\Entity\Property @ORM\OneToMany(targetEntity="Application\Entity\Property", mappedBy="product", cascade={"persist"})
     */
    private $property;

    /**
     *
     * @var \Feed @ORM\ManyToOne(targetEntity="Feed")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="feed_id", referencedColumnName="id")
     *      })
     */
    private $feed;

    /**
     *
     * @var \Brand @ORM\ManyToOne(targetEntity="Brand")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="brand_id", referencedColumnName="id")
     *      })
     */
    private $brand;

    /**
     *
     * @var integer @ORM\Column(name="created_by", type="integer", nullable=false)
     */
    private $createdBy;

    /**
     *
     * @var integer @ORM\Column(name="modified_by", type="integer", nullable=true)
     */
    private $modifiedBy;

    /**
     *
     * @var \DateTime @ORM\Column(name="creation_date", type="datetime", nullable=false)
     */
    private $creationDate;

    /**
     *
     * @var \DateTime @ORM\Column(name="modified_date", type="datetime", nullable=true)
     */
    private $modifiedDate;

    /**
     *
     * @var string @ORM\Column(name="status", type="string", length=255, nullable=false)
     */
    private $status = 'Active';

    /**
     *
     * @var \Application\Entity\Category @ORM\ManyToOne(targetEntity="Application\Entity\Category", inversedBy="product")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *      })
     */
    private $category;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productImage = new \Doctrine\Common\Collections\ArrayCollection();
        $this->property = new \Doctrine\Common\Collections\ArrayCollection();
        $this->feed = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set uniqueId
     *
     * @param string $uniqueId            
     *
     * @return Product
     */
    public function setUniqueId($uniqueId)
    {
        $this->uniqueId = $uniqueId;
        
        return $this;
    }

    /**
     * Get uniqueId
     *
     * @return string
     */
    public function getUniqueId()
    {
        return $this->uniqueId;
    }

    /**
     * Set programId
     *
     * @param integer $programId            
     *
     * @return Product
     */
    public function setProgramId($programId)
    {
        $this->programId = $programId;
        
        return $this;
    }

    /**
     * Get programId
     *
     * @return integer
     */
    public function getProgramId()
    {
        return $this->programId;
    }

    /**
     * Set name
     *
     * @param string $name            
     *
     * @return Product
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
     * Set url
     *
     * @param string $url            
     *
     * @return Product
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
     * Set description
     *
     * @param string $description            
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;
        
        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add productImage
     *
     * @param \Application\Entity\ProductImage $productImage            
     *
     * @return Product
     */
    public function addProductImage(\Application\Entity\ProductImage $productImage)
    {
        $this->productImage[] = $productImage;
        
        return $this;
    }

    /**
     * Remove productImage
     *
     * @param \Application\Entity\ProductImage $productImage            
     */
    public function removeProductImage(\Application\Entity\ProductImage $productImage)
    {
        $this->productImage->removeElement($productImage);
    }

    /**
     * Get productImage
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductImage()
    {
        return $this->productImage;
    }

    /**
     * Add property
     *
     * @param \Application\Entity\Property $property            
     *
     * @return Product
     */
    public function addProperty(\Application\Entity\Property $property)
    {
        $this->property[] = $property;
        
        return $this;
    }

    /**
     * Remove property
     *
     * @param \Application\Entity\Property $property            
     */
    public function removeProperty(\Application\Entity\Property $property)
    {
        $this->property->removeElement($property);
    }

    /**
     * Get property
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Set category
     *
     * @param \Application\Entity\Category $category            
     *
     * @return Product
     */
    public function setCategory(\Application\Entity\Category $category = null)
    {
        $this->category = $category;
        
        return $this;
    }

    /**
     * Get category
     *
     * @return \Application\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate            
     *
     * @return Product
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
        
        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate            
     *
     * @return Product
     */
    public function setModifiedDate($modifiedDate = null)
    {
        $this->modifiedDate = $modifiedDate;
        
        return $this;
    }

    /**
     * Get modifiedDate
     *
     * @return \DateTime
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * Set status
     *
     * @param string $status            
     *
     * @return Product
     */
    public function setStatus($status)
    {
        $this->status = $status;
        
        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdBy
     *
     * @param integer $createdBy            
     *
     * @return Product
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        
        return $this;
    }

    /**
     * Get createdBy
     *
     * @return integer
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set modifiedBy
     *
     * @param integer $modifiedBy            
     *
     * @return Product
     */
    public function setModifiedBy($modifiedBy = null)
    {
        $this->modifiedBy = $modifiedBy;
        
        return $this;
    }

    /**
     * Get modifiedBy
     *
     * @return integer
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    /**
     * Set feed
     *
     * @param \Application\Entity\Feed $feed            
     *
     * @return Product
     */
    public function setFeed(\Application\Entity\Feed $feed = null)
    {
        $this->feed = $feed;
        
        return $this;
    }

    /**
     * Get feed
     *
     * @return \Application\Entity\Feed
     */
    public function getFeed()
    {
        return $this->feed;
    }

    /**
     * Set brand
     *
     * @param \Application\Entity\Brand $brand
     *
     * @return Product
     */
    public function setBrand(\Application\Entity\Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \Application\Entity\Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }
}