<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Todo
 *
 * @ORM\Table(name="todo", indexes={@ORM\Index(name="account_id", columns={"account_id"})})
 * @ORM\Entity
 */
class Todo
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
     * @var string @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     *
     * @var string @ORM\Column(name="status", type="string", length=255, nullable=false)
     */
    private $status = 'Active';

    /**
     *
     * @var \DateTime @ORM\Column(name="creation_date", type="datetime", nullable=false)
     */
    private $creationDate;

    /**
     *
     * @var \User @ORM\ManyToOne(targetEntity="User")
     *      @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="account_id", referencedColumnName="id", onDelete="SET NULL")
     *      })
     */
    private $account;

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
     * Set description
     *
     * @param string $description
     *
     * @return Todo
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Todo
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
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Todo
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
     * Set account
     *
     * @param \Application\Entity\User $account
     *
     * @return Todo
     */
    public function setAccount(\Application\Entity\User $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \Application\Entity\User
     */
    public function getAccount()
    {
        return $this->account;
    }
}
