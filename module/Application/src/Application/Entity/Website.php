<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Website
 *
 * @ORM\Table(name="website")
 * @ORM\Entity
 */
class Website
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
     * @var string @ORM\Column(name="status", type="string", length=10, nullable=false)
     */
    private $status;

    /**
     *
     * @var \Doctrine\Common\Collections\Collection @ORM\ManyToMany(targetEntity="Bolt", inversedBy="website")
     *      @ORM\JoinTable(name="rel_website_bolt",
     *      joinColumns={
     *      @ORM\JoinColumn(name="website_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *      @ORM\JoinColumn(name="bolt_id", referencedColumnName="id", onDelete="CASCADE")
     *      }
     *      )
     */
    private $bolt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bolt = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Website
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
     * Set status
     *
     * @param string $status            
     *
     * @return Website
     */
    public function setStatus($status)
    {
        $this->status = $status;
        
        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add bolt
     *
     * @param \Application\Entity\Bolt $bolt            
     *
     * @return Website
     */
    public function addBolt(\Application\Entity\Bolt $bolt)
    {
        $this->bolt[] = $bolt;
        
        return $this;
    }

    /**
     * Remove bolt
     *
     * @param \Application\Entity\Bolt $bolt            
     */
    public function removeBolt(\Application\Entity\Bolt $bolt)
    {
        $this->bolt->removeElement($bolt);
    }

    /**
     * Get bolt
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBolt()
    {
        return $this->bolt;
    }
}
