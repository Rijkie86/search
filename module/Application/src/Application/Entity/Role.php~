<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 *
 * @ORM\Table(name="role", indexes={@ORM\Index(name="parent_id", columns={"parent_id"})})
 * @ORM\Entity
 */
class Role
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
     * @var \Role @ORM\ManyToOne(targetEntity="Role")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     *      })
     */
    private $parent;

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
     * @return Role
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
     * Set parent
     *
     * @param \Application\Entity\Role $parent
     *
     * @return Role
     */
    public function setParent(\Application\Entity\Role $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Application\Entity\Role
     */
    public function getParent()
    {
        return $this->parent;
    }
}
