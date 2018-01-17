<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FeedDelivery
 *
 * @ORM\Table(name="feed_delivery", uniqueConstraints={@ORM\UniqueConstraint(name="feed_id", columns={"feed_id"})})
 * @ORM\Entity
 */
class FeedDelivery
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
     * @var \Feed @ORM\OneToOne(targetEntity="Feed")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="feed_id", referencedColumnName="id", onDelete="CASCADE")
     *      })
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
     * @return FeedDelivery
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
}
