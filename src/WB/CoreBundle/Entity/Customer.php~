<?php

namespace WB\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WB\CoreBundle\Entity\Customer
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity
 */
class Customer
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
     * @var string $company
     *
     * @ORM\Column(name="company", type="string", length=255, nullable=false)
     */
    private $company;

    /**
     * @var string $logo
     *
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var integer $number
     *
     * @ORM\Column(name="number", type="bigint", nullable=false)
     */
    private $number;

    /**
     * @var integer $headoffice
     *
     * @ORM\Column(name="headoffice", type="bigint", nullable=false)
     */
    private $headoffice;

    /**
     * @var $Address
     *
     * @ORM\OneToMany(targetEntity="Address", mappedBy="customer")
     */
    protected $Address;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Address = new \Doctrine\Common\Collections\ArrayCollection();
    }
    public function __toString(){
        return $this->getCompany();
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
     * Set company
     *
     * @param string $company
     * @return Customer
     */
    public function setCompany($company)
    {
        $this->company = $company;
    
        return $this;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return Customer
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    
        return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Customer
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return Customer
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
     * Set headoffice
     *
     * @param integer $headoffice
     * @return Customer
     */
    public function setHeadoffice($headoffice)
    {
        $this->headoffice = $headoffice;
    
        return $this;
    }

    /**
     * Get headoffice
     *
     * @return integer 
     */
    public function getHeadoffice()
    {
        return $this->headoffice;
    }

    
    /**
     * Add Address
     *
     * @param WB\CoreBundle\Entity\Address $address
     * @return Customer
     */
    public function addAddres(\WB\CoreBundle\Entity\Address $address)
    {
        $this->Address[] = $address;
    
        return $this;
    }

    /**
     * Remove Address
     *
     * @param WB\CoreBundle\Entity\Address $address
     */
    public function removeAddres(\WB\CoreBundle\Entity\Address $address)
    {
        $this->Address->removeElement($address);
    }

    /**
     * Get Address
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAddress()
    {
        return $this->Address;
    }
}