<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Florian Engler
 * Mail: florian.engler@gmx.de
 * Date: 17.12.12
 * Time: 15:27
 */

namespace WB\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WB\CoreBundle\Entity\Company
 *
 * @ORM\Table(name="company")
 * @ORM\Entity
 */
class Company{

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $settings
     *
     * @ORM\Column(name="settings", type="array" )
     */
    private $settings;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity="Acme\UserBundle\Entity\User", mappedBy="company")
     */
    protected $Users;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Company
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
     * Set settings
     *
     * @param array $settings
     * @return Company
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
    
        return $this;
    }

    /**
     * Get settings
     *
     * @return array 
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Company
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
     * Add Users
     *
     * @param Acme\UserBundle\Entity\User $users
     * @return Company
     */
    public function addUser(\Acme\UserBundle\Entity\User $users)
    {
        $this->Users[] = $users;
    
        return $this;
    }

    /**
     * Remove Users
     *
     * @param Acme\UserBundle\Entity\User $users
     */
    public function removeUser(\Acme\UserBundle\Entity\User $users)
    {
        $this->Users->removeElement($users);
    }

    /**
     * Get Users
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->Users;
    }
}