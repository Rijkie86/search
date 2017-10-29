<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FeedCategoryValue
 *
 * @ORM\Table(name="feed_category_value", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})}, indexes={@ORM\Index(name="feed_category_id", columns={"feed_category_id"})})
 * @ORM\Entity
 */
class FeedCategoryValue
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
     * @var \Application\Entity\FeedCategory @ORM\ManyToOne(targetEntity="Application\Entity\FeedCategory", inversedBy="feedCategoryValue")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="feed_category_id", referencedColumnName="id")
     *      })
     */
    private $feedCategory;

    /**
     *
     * @var \Doctrine\Common\Collections\Collection @ORM\ManyToMany(targetEntity="Application\Entity\Category", mappedBy="feedCategoryValue")
     */
    private $category;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->category = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return FeedCategoryValue
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
     * Set feedCategory
     *
     * @param \Application\Entity\FeedCategory $feedCategory            
     *
     * @return FeedCategoryValue
     */
    public function setFeedCategory(\Application\Entity\FeedCategory $feedCategory = null)
    {
        $this->feedCategory = $feedCategory;
        
        return $this;
    }

    /**
     * Get feedCategory
     *
     * @return \Application\Entity\FeedCategory
     */
    public function getFeedCategory()
    {
        return $this->feedCategory;
    }

    /**
     * Add category
     *
     * @param \Application\Entity\Category $category            
     *
     * @return FeedCategoryValue
     */
    public function addCategory(\Application\Entity\Category $category)
    {
        if ($this->category->contains($category)) {
            return;
        }
        
        $this->category->add($category);
        $category->addFeedCategoryValue($this);
    }

    /**
     * Remove category
     *
     * @param \Application\Entity\Category $category            
     */
    public function removeCategory(\Application\Entity\Category $category)
    {
        if(!$this->category->contains($category)) {
            return;
        }

        $this->category->removeElement($category);
        $category->removeFeedCategoryValue($this);
    }

    /**
     * Get category
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategory()
    {
        return $this->category;
    }
}
