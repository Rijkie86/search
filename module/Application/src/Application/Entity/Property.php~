<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Property
 *
 * @ORM\Table(name="property", indexes={@ORM\Index(name="IDX_8BF21CDE4584665A", columns={"product_id"})})
 * @ORM\Entity
 * @ORM\EntityListeners({"Application\Entity\Listener\PropertyListener"})
 */
class Property
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
     * @var string @ORM\Column(name="value", type="string", length=2500, nullable=false)
     */
    private $value;

    /**
     *
     * @var \Application\Entity\Product @ORM\ManyToOne(targetEntity="Application\Entity\Product")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     *      })
     */
    private $product;

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
     * @return Property
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
     * Set value
     *
     * @param string $value            
     *
     * @return Property
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

    /**
     * Set product
     *
     * @param \Application\Entity\Product $product            
     *
     * @return Property
     */
    public function setProduct(\Application\Entity\Product $product = null)
    {
        $this->product = $product;
        
        return $this;
    }

    /**
     * Get product
     *
     * @return \Application\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
