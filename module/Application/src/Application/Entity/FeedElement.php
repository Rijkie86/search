<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FeedElement
 *
 * @ORM\Table(name="feed_element", indexes={@ORM\Index(name="feed_id", columns={"feed_id"})})
 * @ORM\Entity
 */
class FeedElement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="feed_id", type="integer", nullable=false)
     */
    private $feedId;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=false)
     */
    private $value;



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
     * Set feedId
     *
     * @param integer $feedId
     *
     * @return FeedElement
     */
    public function setFeedId($feedId)
    {
        $this->feedId = $feedId;

        return $this;
    }

    /**
     * Get feedId
     *
     * @return integer
     */
    public function getFeedId()
    {
        return $this->feedId;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return FeedElement
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
