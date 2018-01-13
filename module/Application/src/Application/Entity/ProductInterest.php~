<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductInterest
 *
 * @ORM\Table(name="product_interest", indexes={@ORM\Index(name="product_id", columns={"product_id"}), @ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class ProductInterest
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
     * @var \DateTime @ORM\Column(name="creation_date", type="datetime", nullable=false)
     */
    private $creationDate;

    /**
     *
     * @var \Application\Entity\Product @ORM\ManyToOne(targetEntity="Application\Entity\Product")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     *      })
     */
    private $product;

    /**
     *
     * @var \Application\Entity\User @ORM\ManyToOne(targetEntity="Application\Entity\User")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     *      })
     */
    private $user;

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
     * Set creationDate
     *
     * @param \DateTime $creationDate            
     *
     * @return ProductInterest
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
        
        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set product
     *
     * @param \Application\Entity\Product $product            
     *
     * @return ProductInterest
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

    /**
     * Set user
     *
     * @param \Application\Entity\User $user            
     *
     * @return ProductInterest
     */
    public function setUser(\Application\Entity\User $user = null)
    {
        $this->user = $user;
        
        return $this;
    }

    /**
     * Get user
     *
     * @return \Application\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
