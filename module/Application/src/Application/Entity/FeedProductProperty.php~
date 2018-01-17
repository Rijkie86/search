<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FeedProductProperty
 *
 * @ORM\Table(name="feed_product_property", uniqueConstraints={@ORM\UniqueConstraint(name="feed_id", columns={"feed_id", "name"})}, indexes={@ORM\Index(name="IDX_499772F651A5BC03", columns={"feed_id"}), @ORM\Index(name="list_object_id", columns={"list_object_id"})})
 * @ORM\Entity
 */
class FeedProductProperty
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
     * @var string @ORM\Column(name="db_table_property", type="string", length=255, nullable=true)
     */
    private $dbTableProperty;

    /**
     *
     * @var \DateTime @ORM\Column(name="modified_date", type="datetime", nullable=true)
     */
    private $modifiedDate;

    /**
     *
     * @var boolean @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active = '1';

    /**
     *
     * @var boolean @ORM\Column(name="locked", type="boolean", nullable=false)
     */
    private $locked = '0';

    /**
     *
     * @var \ListObject @ORM\ManyToOne(targetEntity="ListObject")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="list_object_id", referencedColumnName="id", onDelete="CASCADE")
     *      })
     */
    private $listObject;

    /**
     *
     * @var \Feed @ORM\ManyToOne(targetEntity="Feed", inversedBy="feedProductProperty")
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
     * Set name
     *
     * @param string $name            
     *
     * @return FeedProductProperty
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
     * Set feed
     *
     * @param \Application\Entity\Feed $feed            
     *
     * @return FeedProductProperty
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
     * Set active
     *
     * @param boolean $active            
     *
     * @return FeedProductProperty
     */
    public function setActive($active)
    {
        $this->active = $active;
        
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set dbTableProperty
     *
     * @param string $dbTableProperty            
     *
     * @return FeedProductProperty
     */
    public function setDbTableProperty($dbTableProperty)
    {
        $this->dbTableProperty = $dbTableProperty;
        
        return $this;
    }

    /**
     * Get dbTableProperty
     *
     * @return string
     */
    public function getDbTableProperty()
    {
        return $this->dbTableProperty;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate            
     *
     * @return FeedProductProperty
     */
    public function setModifiedDate($modifiedDate)
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
     * Set listObject
     *
     * @param \Application\Entity\ListObject $listObject            
     *
     * @return FeedProductProperty
     */
    public function setListObject(\Application\Entity\ListObject $listObject = null)
    {
        $this->listObject = $listObject;
        
        return $this;
    }

    /**
     * Get listObject
     *
     * @return \Application\Entity\ListObject
     */
    public function getListObject()
    {
        return $this->listObject;
    }

    /**
     * Set locked
     *
     * @param boolean $locked            
     *
     * @return FeedProductProperty
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;
        
        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }
}
