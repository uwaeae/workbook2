<?php

namespace WB\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WB\CoreBundle\Entity\Invoice
 *
 * @ORM\Table(name="invoice")
 * @ORM\Entity
 */
class Invoice
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer $number
     *
     * @ORM\Column(name="number", type="bigint", nullable=false)
     */
    private $number;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Job", mappedBy="invoice")
     */
    private $job;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->job = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString(){
        return $this->getNumber();
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
     * Set number
     *
     * @param integer $number
     * @return Invoice
     */
    public function setNumber($number)
    {
        $this->number = $number;
    
        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Invoice
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Invoice
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add job
     *
     * @param WB\CoreBundle\Entity\Job $job
     * @return Invoice
     */
    public function addJob(\WB\CoreBundle\Entity\Job $job)
    {
        $this->job[] = $job;
    
        return $this;
    }

    /**
     * Remove job
     *
     * @param WB\CoreBundle\Entity\Job $job
     */
    public function removeJob(\WB\CoreBundle\Entity\Job $job)
    {
        $this->job->removeElement($job);
    }

    /**
     * Get job
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getJob()
    {
        return $this->job;
    }
}