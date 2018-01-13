<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Accommodation
 *
 * @ORM\Table(name="accommodation", indexes={@ORM\Index(name="list_accommodation_type_id", columns={"list_accommodation_type_id"})})
 * @ORM\Entity
 */
class Accommodation
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
     * @var string @ORM\Column(name="latitude", type="string", length=255, nullable=true)
     */
    private $latitude;

    /**
     *
     * @var string @ORM\Column(name="longitude", type="string", length=255, nullable=true)
     */
    private $longitude;

    /**
     *
     * @var \ListAccommodationType @ORM\ManyToOne(targetEntity="ListAccommodationType")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="list_accommodation_type_id", referencedColumnName="id", onDelete="CASCADE")
     *      })
     */
    private $listAccommodationType;

    /**
     *
     * @var \Doctrine\Common\Collections\Collection @ORM\ManyToMany(targetEntity="Product", mappedBy="accommodation")
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
     * Set listAccommodationType
     *
     * @param \Application\Entity\ListAccommodationType $listAccommodationType            
     *
     * @return Accommodation
     */
    public function setListAccommodationType(\Application\Entity\ListAccommodationType $listAccommodationType = null)
    {
        $this->listAccommodationType = $listAccommodationType;
        
        return $this;
    }

    /**
     * Get listAccommodationType
     *
     * @return \Application\Entity\ListAccommodationType
     */
    public function getListAccommodationType()
    {
        return $this->listAccommodationType;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add product
     *
     * @param \Application\Entity\Product $product            
     *
     * @return Accommodation
     */
    public function addProduct(\Application\Entity\Product $product)
    {
        $this->product[] = $product;
        
        return $this;
    }

    /**
     * Remove product
     *
     * @param \Application\Entity\Product $product            
     */
    public function removeProduct(\Application\Entity\Product $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Accommodation
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Accommodation
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}
