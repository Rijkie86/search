<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FeedCategory
 *
 * @ORM\Table(name="feed_category", indexes={@ORM\Index(name="feed_id", columns={"feed_id"})})
 * @ORM\Entity
 */
class FeedCategory
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
     * @var \Application\Entity\FeedCategory @ORM\OneToMany(targetEntity="Application\Entity\FeedCategoryValue", mappedBy="feedCategory", cascade={"persist"})
     */
    private $feedCategoryValue;

    /**
     *
     * @var \Application\Entity\Feed @ORM\OneToOne(targetEntity="Application\Entity\Feed", inversedBy="feedCategory")
     */
    private $feed;

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
     * Set feed
     *
     * @param \Application\Entity\Feed $feed            
     *
     * @return FeedCategory
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
     * Constructor
     */
    public function __construct()
    {
        $this->feedCategoryValue = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add feedCategoryValue
     *
     * @param \Application\Entity\FeedCategoryValue $feedCategoryValue
     *
     * @return FeedCategory
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
}
