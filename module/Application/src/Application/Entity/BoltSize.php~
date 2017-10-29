<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BoltSize
 *
 * @ORM\Table(name="bolt_size", indexes={@ORM\Index(name="bolt_id", columns={"bolt_id"})})
 * @ORM\Entity
 */
class BoltSize
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
     * @var boolean @ORM\Column(name="metric", type="smallint", nullable=false)
     */
    private $metric;

    /**
     *
     * @var boolean @ORM\Column(name="steel_length", type="smallint", nullable=false)
     */
    private $steelLength;
    
    /**
     *
     * @var string @ORM\Column(name="quality", type="string", length=255, nullable=false)
     */
    private $quality;
    
    /**
     *
     * @var \Bolt @ORM\ManyToOne(targetEntity="Bolt", inversedBy="boltSize")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="bolt_id", referencedColumnName="id")
     *      })
     */
    private $bolt;

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
     * Set metric
     *
     * @param boolean $metric            
     *
     * @return BoltSize
     */
    public function setMetric($metric)
    {
        $this->metric = $metric;
        
        return $this;
    }

    /**
     * Get metric
     *
     * @return boolean
     */
    public function getMetric()
    {
        return $this->metric;
    }

    /**
     * Set steelLength
     *
     * @param boolean $steelLength            
     *
     * @return BoltSize
     */
    public function setSteelLength($steelLength)
    {
        $this->steelLength = $steelLength;
        
        return $this;
    }

    /**
     * Get steelLength
     *
     * @return boolean
     */
    public function getSteelLength()
    {
        return $this->steelLength;
    }

    /**
     * Set bolt
     *
     * @param \Application\Entity\Bolt $bolt            
     *
     * @return BoltSize
     */
    public function setBolt(\Application\Entity\Bolt $bolt = null)
    {
        $this->bolt = $bolt;
        
        return $this;
    }

    /**
     * Get bolt
     *
     * @return \Application\Entity\Bolt
     */
    public function getBolt()
    {
        return $this->bolt;
    }

    /**
     * Set quality
     *
     * @param string $quality
     *
     * @return BoltSize
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;

        return $this;
    }

    /**
     * Get quality
     *
     * @return string
     */
    public function getQuality()
    {
        return $this->quality;
    }
}
