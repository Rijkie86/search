<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShellLogProduct
 *
 * @ORM\Table(name="shell_log_product", indexes={@ORM\Index(name="product_id", columns={"product_id"})})
 * @ORM\Entity
 */
class ShellLogProduct
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
     * @var \Application\Entity\Product @ORM\ManyToOne(targetEntity="Application\Entity\Product")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
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
     * Set product
     *
     * @param \Application\Entity\Product $product            
     *
     * @return ShellLogProduct
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
