<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Application\Repository\CategoryRepository")
 */
class Category
{

    /**
     *
     * @var bool @ORM\Column(name="id", type="smallint", nullable=false)
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
     * @var string @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     *
     * @var \Application\Entity\Category @ORM\ManyToOne(targetEntity="Application\Entity\Category", inversedBy="children")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     *      })
     */
    private $parent;

    /**
     *
     * @var \Application\Entity\Category @ORM\OneToMany(targetEntity="Application\Entity\Category", mappedBy="parent")
     */
    private $children;

    /**
     *
     * @var \Application\Entity\Product @ORM\OneToMany(targetEntity="Application\Entity\Product", mappedBy="category")
     */
    private $product;

    /**
     *
     * @var \Doctrine\Common\Collections\Collection @ORM\ManyToMany(targetEntity="FeedCategoryValue", inversedBy="category")
     *      @ORM\JoinTable(name="rel_category_feed_category_value",
     *      joinColumns={
     *      @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *      @ORM\JoinColumn(name="feed_category_value_id", referencedColumnName="id", onDelete="CASCADE")
     *      }
     *      )
     */
    private $feedCategoryValue;

    /**
     * Get id
     *
     * @return bool
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
     * @return Category
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
     * Set parent
     *
     * @param \Application\Entity\Category $parent            
     *
     * @return Category
     */
    public function setParent(\Application\Entity\Category $parent = null)
    {
        $this->parent = $parent;
        
        return $this;
    }

    /**
     * Get parent
     *
     * @return \Application\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param \Application\Entity\Category $child            
     *
     * @return Category
     */
    public function addChild(\Application\Entity\Category $child)
    {
        $this->children[] = $child;
        
        return $this;
    }

    /**
     * Remove child
     *
     * @param \Application\Entity\Category $child            
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeChild(\Application\Entity\Category $child)
    {
        return $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Add product
     *
     * @param \Application\Entity\Product $product            
     *
     * @return Category
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
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeProduct(\Application\Entity\Product $product)
    {
        return $this->product->removeElement($product);
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

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
        $this->feedCategoryValue = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add feedCategoryValue
     *
     * @param \Application\Entity\FeedCategoryValue $feedCategoryValue            
     *
     * @return Category
     */
    public function addFeedCategoryValue(\Application\Entity\FeedCategoryValue $feedCategoryValue)
    {
        $this->feedCategoryValue[] = $feedCategoryValue;
        
        return $this;
    }

    /**
     * Remove feedCategoryValue
     *
     * @param \Application\Entity\FeedCategoryValue $feedCategoryValue            
     */
    public function removeFeedCategoryValue(\Application\Entity\FeedCategoryValue $feedCategoryValue)
    {
        $this->feedCategoryValue->removeElement($feedCategoryValue);
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
     * Set description
     *
     * @param string $description            
     *
     * @return Category
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
}
