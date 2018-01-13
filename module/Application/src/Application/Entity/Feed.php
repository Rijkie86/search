<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Feed
 *
 * @ORM\Table(name="feed", indexes={@ORM\Index(name="program_id", columns={"program_id"})})
 * @ORM\Entity
 */
class Feed
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
     * @var integer @ORM\Column(name="program_id", type="integer", nullable=true)
     */
    private $programId;

    /**
     *
     * @var integer @ORM\Column(name="product_count", type="integer", nullable=true)
     */
    private $productCount;

    /**
     *
     * @var string @ORM\Column(name="file", type="string", length=255, nullable=false)
     */
    private $file;

    /**
     *
     * @var \DateTime @ORM\Column(name="last_run", type="datetime", nullable=true)
     */
    private $lastRun;

    /**
     *
     * @var \Application\Entity\Feed @ORM\OneToOne(targetEntity="Application\Entity\FeedCategory", mappedBy="feed", cascade={"persist"})
     */
    private $feedCategory;

    /**
     *
     * @var \Feed @ORM\OneToMany(targetEntity="FeedProductProperty", mappedBy="feed", cascade={"persist"})
     */
    private $feedProductProperty;

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
     * Set programId
     *
     * @param integer $programId            
     *
     * @return Feed
     */
    public function setProgramId($programId = null)
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
     * Set productCount
     *
     * @param integer $productCount            
     *
     * @return Feed
     */
    public function setProductCount($productCount = null)
    {
        $this->productCount = $productCount;
        
        return $this;
    }

    /**
     * Get productCount
     *
     * @return integer
     */
    public function getProductCount()
    {
        return $this->productCount;
    }

    /**
     * Set file
     *
     * @param string $file            
     *
     * @return Feed
     */
    public function setFile($file)
    {
        $this->file = $file;
        
        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set feedCategory
     *
     * @param \Application\Entity\FeedCategory $feedCategory            
     *
     * @return Feed
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
     * Add feedProductProperty
     *
     * @param \Application\Entity\FeedProductProperty $feedProductProperty            
     *
     * @return Feed
     */
    public function addFeedProductProperty(\Application\Entity\FeedProductProperty $feedProductProperty)
    {
        $this->feedProductProperty[] = $feedProductProperty;
        
        return $this;
    }

    /**
     * Remove feedProductProperty
     *
     * @param \Application\Entity\FeedProductProperty $feedProductProperty            
     */
    public function removeFeedProductProperty(\Application\Entity\FeedProductProperty $feedProductProperty)
    {
        $this->feedProductProperty->removeElement($feedProductProperty);
    }

    /**
     * Get feedProductProperty
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFeedProductProperty()
    {
        return $this->feedProductProperty;
    }

    /**
     * Set lastRun
     *
     * @param \DateTime $lastRun            
     *
     * @return Feed
     */
    public function setLastRun($lastRun)
    {
        $this->lastRun = $lastRun;
        
        return $this;
    }

    /**
     * Get lastRun
     *
     * @return \DateTime
     */
    public function getLastRun()
    {
        return $this->lastRun;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->feedProductProperty = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
