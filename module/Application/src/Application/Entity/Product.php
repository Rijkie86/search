<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="IDX_D34A04AD51A5BC03", columns={"feed_id"}), @ORM\Index(name="category_id", columns={"category_id"}), @ORM\Index(name="unique_id", columns={"unique_id"})})
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
     * @var string @ORM\Column(name="seo_title", type="string", length=65, nullable=true)
     */
    private $seoTitle;

    /**
     *
     * @var string @ORM\Column(name="seo_description", type="string", length=230, nullable=true)
     */
    private $seoDescription;

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
     * @var string @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     *
     * @var string @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     *
     * @var string @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     *
     * @var string @ORM\Column(name="price", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $price;

    /**
     *
     * @var \Application\Entity\ProductImage @ORM\OneToMany(targetEntity="Application\Entity\ProductImage", mappedBy="product", cascade={"persist"})
     */
    private $productImage;

    /**
     *
     * @var \Application\Entity\Property @ORM\OneToMany(targetEntity="Application\Entity\Property", mappedBy="product", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $property;

    /**
     *
     * @var \Feed @ORM\ManyToOne(targetEntity="Feed")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="feed_id", referencedColumnName="id", onDelete="CASCADE")
     *      })
     */
    private $feed;

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
     * @var boolean @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status = '1';

    /**
     *
     * @var \Application\Entity\Category @ORM\ManyToOne(targetEntity="Application\Entity\Category", inversedBy="product")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *      })
     */
    private $category;

    /**
     *
     * @var \Doctrine\Common\Collections\Collection @ORM\ManyToMany(targetEntity="Brand", inversedBy="product", cascade={"persist"})
     *      @ORM\JoinTable(name="rel_product_brand",
     *      joinColumns={
     *      @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *      @ORM\JoinColumn(name="brand_id", referencedColumnName="id", onDelete="CASCADE")
     *      }
     *      )
     */
    private $brand;

    /**
     *
     * @var \Doctrine\Common\Collections\Collection @ORM\ManyToMany(targetEntity="FeedCategoryValue", inversedBy="product", cascade={"persist"})
     *      @ORM\JoinTable(name="rel_product_feed_category_value",
     *      joinColumns={
     *      @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *      @ORM\JoinColumn(name="feed_category_value_id", referencedColumnName="id", onDelete="CASCADE")
     *      }
     *      )
     */
    private $feedCategoryValue;

    /**
     *
     * @var \Doctrine\Common\Collections\Collection @ORM\ManyToMany(targetEntity="Accommodation", inversedBy="product", cascade={"persist"})
     *      @ORM\JoinTable(name="rel_product_accommodation",
     *      joinColumns={
     *      @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *      @ORM\JoinColumn(name="accommodation_id", referencedColumnName="id", onDelete="CASCADE")
     *      }
     *      )
     */
    private $accommodation;

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
     * Add brand
     *
     * @param \Application\Entity\Brand $brand            
     *
     * @return Product
     */
    public function addBrand(\Application\Entity\Brand $brand)
    {
        if ($this->brand->contains($brand)) {
            return;
        }
        
        $this->brand->add($brand);
        $brand->addProduct($this);
    }

    /**
     * Remove brand
     *
     * @param \Application\Entity\Brand $brand            
     */
    public function removeBrand(\Application\Entity\Brand $brand)
    {
        if (! $this->brand->contains($brand)) {
            return;
        }
        
        $this->brand->removeElement($brand);
        $brand->removeProduct($this);
    }

    /**
     * Get brand
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Add feedCategoryValue
     *
     * @param \Application\Entity\FeedCategoryValue $feedCategoryValue            
     *
     * @return Product
     */
    public function addFeedCategoryValue(\Application\Entity\FeedCategoryValue $feedCategoryValue)
    {
        if ($this->feedCategoryValue->contains($feedCategoryValue)) {
            return;
        }
        
        $this->feedCategoryValue->add($feedCategoryValue);
        $feedCategoryValue->addProduct($this);
    }

    /**
     * Remove feedCategoryValue
     *
     * @param \Application\Entity\FeedCategoryValue $feedCategoryValue            
     */
    public function removeFeedCategoryValue(\Application\Entity\FeedCategoryValue $feedCategoryValue)
    {
        if (! $this->feedCategoryValue->contains($feedCategoryValue)) {
            return;
        }
        
        $this->feedCategoryValue->removeElement($feedCategoryValue);
        $feedCategoryValue->removeProduct($this);
    }

    /**
     * Get feedCategoryValue
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFeedCategoryValue()
    {
        return $this->feedCategoryValue;
    }

    /**
     * Set price
     *
     * @param string $price            
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;
        
        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set status
     *
     * @param boolean $status            
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
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
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
     * Set seoTitle
     *
     * @param string $seoTitle            
     *
     * @return Product
     */
    public function setSeoTitle($seoTitle)
    {
        $this->seoTitle = $seoTitle;
        
        return $this;
    }

    /**
     * Get seoTitle
     *
     * @return string
     */
    public function getSeoTitle()
    {
        return $this->seoTitle;
    }

    /**
     * Set seoDescription
     *
     * @param string $seoDescription            
     *
     * @return Product
     */
    public function setSeoDescription($seoDescription)
    {
        $this->seoDescription = $seoDescription;
        
        return $this;
    }

    /**
     * Get seoDescription
     *
     * @return string
     */
    public function getSeoDescription()
    {
        return $this->seoDescription;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productImage = new \Doctrine\Common\Collections\ArrayCollection();
        $this->property = new \Doctrine\Common\Collections\ArrayCollection();
        $this->brand = new \Doctrine\Common\Collections\ArrayCollection();
        $this->feedCategoryValue = new \Doctrine\Common\Collections\ArrayCollection();
        $this->accommodation = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add accommodation
     *
     * @param \Application\Entity\Accommodation $accommodation            
     *
     * @return Product
     */
    public function addAccommodation(\Application\Entity\Accommodation $accommodation)
    {
        if ($this->accommodation->contains($accommodation)) {
            return;
        }
        
        $this->accommodation->add($accommodation);
        $accommodation->addProduct($this);
    }

    /**
     * Remove accommodation
     *
     * @param \Application\Entity\Accommodation $accommodation            
     */
    public function removeAccommodation(\Application\Entity\Accommodation $accommodation)
    {
        if (! $this->accommodation->contains($accommodation)) {
            return;
        }
        
        $this->accommodation->removeElement($accommodation);
        $accommodation->removeProduct($this);
    }

    /**
     * Get accommodation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAccommodation()
    {
        return $this->accommodation;
    }
}
