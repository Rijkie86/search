<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bolt
 *
 * @ORM\Table(name="bolt")
 * @ORM\Entity
 */
class Bolt
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
     * @var \Bolt @ORM\OneToMany(targetEntity="BoltSize", mappedBy="bolt", cascade={"persist"})
     */
    private $boltSize;

    /**
     *
     * @var \Din @ORM\ManyToOne(targetEntity="Din")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="din_id", referencedColumnName="id", onDelete="SET NULL")
     *      })
     */
    private $din;

    /**
     *
     * @var \Doctrine\Common\Collections\Collection @ORM\ManyToMany(targetEntity="Website", mappedBy="bolt")
     */
    private $website;

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
     * @return Bolt
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
     * Set din
     *
     * @param \Application\Entity\Din $din            
     *
     * @return Bolt
     */
    public function setDin(\Application\Entity\Din $din = null)
    {
        $this->din = $din;
        
        return $this;
    }

    /**
     * Get din
     *
     * @return \Application\Entity\Din
     */
    public function getDin()
    {
        return $this->din;
    }

    /**
     * Add website
     *
     * @param \Application\Entity\Website $website            
     *
     * @return Bolt
     */
    public function addWebsite(\Application\Entity\Website $website)
    {
        $this->website[] = $website;
        
        return $this;
    }

    /**
     * Remove website
     *
     * @param \Application\Entity\Website $website            
     */
    public function removeWebsite(\Application\Entity\Website $website)
    {
        $this->website->removeElement($website);
    }

    /**
     * Get website
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->boltSize = new \Doctrine\Common\Collections\ArrayCollection();
        $this->website = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add boltSize
     *
     * @param \Application\Entity\BoltSize $boltSize            
     *
     * @return Bolt
     */
    public function addBoltSize(\Doctrine\Common\Collections\Collection $boltSizes)
    {
        foreach ($boltSizes as $boltSize) {
            $boltSize->setBolt($this);
            $this->boltSize->add($boltSize);
        }
    }

    /**
     * Remove boltSize
     *
     * @param \Application\Entity\BoltSize $boltSize            
     */
    public function removeBoltSize(\Doctrine\Common\Collections\Collection $boltSizes)
    {
        foreach ($boltSizes as $boltSize) {
            $boltSize->setBolt(null);
            $this->boltSize->removeElement($boltSize);
        }
    }

    /**
     * Get boltSize
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBoltSize()
    {
        return $this->boltSize;
    }
}
