<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FeedProductProperty
 *
 * @ORM\Table(name="feed_product_property")
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
     * @var string @ORM\Column(name="db_table", type="string", length=255, nullable=true)
     */
    private $dbTable;

    /**
     *
     * @var string @ORM\Column(name="tb_table_property", type="string", length=255, nullable=true)
     */
    private $tbTableProperty;

    /**
     *
     * @var \Feed @ORM\ManyToOne(targetEntity="Feed")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="feed_id", referencedColumnName="id")
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
     * Set dbTable
     *
     * @param string $dbTable            
     *
     * @return FeedProductProperty
     */
    public function setDbTable($dbTable)
    {
        $this->dbTable = $dbTable;
        
        return $this;
    }

    /**
     * Get dbTable
     *
     * @return string
     */
    public function getDbTable()
    {
        return $this->dbTable;
    }

    /**
     * Set tbTableProperty
     *
     * @param string $tbTableProperty            
     *
     * @return FeedProductProperty
     */
    public function setTbTableProperty($tbTableProperty)
    {
        $this->tbTableProperty = $tbTableProperty;
        
        return $this;
    }

    /**
     * Get tbTableProperty
     *
     * @return string
     */
    public function getTbTableProperty()
    {
        return $this->tbTableProperty;
    }
}
