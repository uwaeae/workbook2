<?php

namespace WB\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WB\CoreBundle\Entity\Taskposition
 *
 * @ORM\Table(name="taskposition")
 * @ORM\Entity
 */
class Taskposition
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
     * @var integer $amount
     *
     * @ORM\Column(name="amount", type="bigint", nullable=false)
     */
    private $amount;

    /**
     * @var Item
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     * })
     */
    private $item;



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
     * Set amount
     *
     * @param integer $amount
     * @return Taskposition
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return integer 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set item
     *
     * @param WB\CoreBundle\Entity\Item $item
     * @return Taskposition
     */
    public function setItem(\WB\CoreBundle\Entity\Item $item = null)
    {
        $this->item = $item;
    
        return $this;
    }

    /**
     * Get item
     *
     * @return WB\CoreBundle\Entity\Item 
     */
    public function getItem()
    {
        return $this->item;
    }
}