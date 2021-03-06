<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ListAccommodationType
 *
 * @ORM\Table(name="_list_accommodation_type")
 * @ORM\Entity
 */
class ListAccommodationType
{

    /**
     *
     * @var integer @ORM\Column(name="id", type="smallint", nullable=false)
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
     * @return ListAccommodationType
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
}
