<?php

namespace Acme\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
//use WB\CoreBundle\Entity\Task


/**
 * WB\CoreBundle\Entity\User
 *
 * @ORM\Table(name="sf_guard_user")
 * @ORM\Entity(repositoryClass="Acme\UserBundle\Entity\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 */
class User implements UserInterface, \Serializable
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
     * @var string $firstName
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string $lastName
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email_address", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string $username
     *
     * @ORM\Column(name="username", type="string", length=128, nullable=false)
     */
    private $username;

    /**
     * @var string $algorithm
     *
     * @ORM\Column(name="algorithm", type="string", length=128, nullable=true)
     */
    private $algorithm;

    /**
     * @var string $salt
     *
     * @ORM\Column(name="salt", type="string", length=128, nullable=true)
     */
    private $salt;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=128, nullable=true)
     */
    private $password;

    /**
     * @var boolean $isActive
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @var boolean $isUser
     *
     * @ORM\Column(name="is_user", type="boolean", nullable=true)
     */
    private $isUser;



    /**
     * @var string $settings
     *
     * @ORM\Column(name="settings", type="string", length=255, nullable=true)
     */
    private $settings;

    /**
     * @var boolean $isSuperAdmin
     *
     * @ORM\Column(name="is_super_admin", type="boolean", nullable=true)
     */
    private $isSuperAdmin;

    /**
     * @var \DateTime $lastLogin
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

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
     * @ORM\ManyToMany(targetEntity="Group", inversedBy="user")
     * @ORM\JoinTable(name="sf_guard_user_group",
     *   joinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     *   }
     * )
     */
    private $groups;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Permission", inversedBy="user")
     * @ORM\JoinTable(name="sf_guard_user_permission",
     *   joinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="permission_id", referencedColumnName="id")
     *   }
     * )
     */

    private $permission;



    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="WB\CoreBundle\Entity\Task", mappedBy="user")
     */
    private $task;


    /**
     * @ORM\ManyToOne(targetEntity="WB\CoreBundle\Entity\Company", inversedBy="Users")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $Company;


    /**
     * @var string $passwordrepeat
     */
    private $passwordrepeat;

    /**
     * @var string $requestCode
     *
     * @ORM\Column(name="requestCode", type="string", length=255, nullable=true)
     */

    private $requestCode;

    /**
     * @var integer $modifiedUser
     *
     * @ORM\Column(name="modified_user", type="integer", nullable=true)
     */
    private $modifiedUser;
    /**
     * @ORM\preUpdate
     */
    public function setUpdatedValue()
    {
        $this->updatedAt = new \DateTime();
    }


    /**
     * Constructor
     */
    public function __construct()
    {

        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->permission = new \Doctrine\Common\Collections\ArrayCollection();
        $this->task = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->roles  = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function __toString(){

        return $this->username;
    }



    /**
     * @inheritDoc
     */
    public function isPasswordLegal()
    {
        return strcmp($this->password, $this->passwordrepeat);
    }
    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        $output = array();
        $roles =  $this->groups->toArray();
        foreach($roles as $role){
            $output[] = $role->getRole();
        }


        return $output;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            ) = unserialize($serialized);
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
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set emailAddress
     *
     * @param string $emailAddress
     * @return User
     */
    public function setEmailAddress($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get emailAddress
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Set algorithm
     *
     * @param string $algorithm
     * @return User
     */
    public function setAlgorithm($algorithm)
    {
        $this->algorithm = $algorithm;
    
        return $this;
    }

    /**
     * Get algorithm
     *
     * @return string 
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set settings
     *
     * @param string $settings
     * @return User
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
    
        return $this;
    }

    /**
     * Get settings
     *
     * @return string 
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Set isSuperAdmin
     *
     * @param boolean $isSuperAdmin
     * @return User
     */
    public function setIsSuperAdmin($isSuperAdmin)
    {
        $this->isSuperAdmin = $isSuperAdmin;
    
        return $this;
    }

    /**
     * Get isSuperAdmin
     *
     * @return boolean 
     */
    public function getIsSuperAdmin()
    {
        return $this->isSuperAdmin;
    }

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    
        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime 
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return User
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
     * @return User
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
     * Add permission
     *
     * @param Acme\UserBundle\Entity\Permission $permission
     * @return User
     */
    public function addPermission(\Acme\UserBundle\Entity\Permission $permission)
    {
        $this->permission[] = $permission;
    
        return $this;
    }

    /**
     * Remove permission
     *
     * @param Acme\UserBundle\Entity\Permission $permission
     */
    public function removePermission(\Acme\UserBundle\Entity\Permission $permission)
    {
        $this->permission->removeElement($permission);
    }

    /**
     * Get permission
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Add task
     *
     * @param WB\CoreBundle\Entity\Task $task
     * @return User
     */
    public function addTask(\WB\CoreBundle\Entity\Task $task)
    {
        $this->task[] = $task;
    
        return $this;
    }

    /**
     * Remove task
     *
     * @param WB\CoreBundle\Entity\Task $task
     */
    public function removeTask(\WB\CoreBundle\Entity\Task $task)
    {
        $this->task->removeElement($task);
    }

    /**
     * Get task
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Set Company
     *
     * @param WB\CoreBundle\Entity\Company $company
     * @return User
     */
    public function setCompany(\WB\CoreBundle\Entity\Company $company = null)
    {
        $this->Company = $company;
    
        return $this;
    }

    /**
     * Get Company
     *
     * @return WB\CoreBundle\Entity\Company 
     */
    public function getCompany()
    {
        return $this->Company;
    }



    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }



    /**
     * Set requestCode
     *
     * @param string $requestCode
     * @return User
     */
    public function setRequestCode($requestCode)
    {
        $this->requestCode = $requestCode;
    
        return $this;
    }

    /**
     * Get requestCode
     *
     * @return string 
     */
    public function getRequestCode()
    {
        return $this->requestCode;



    }

    public function getPasswordrepeat(){
        return $this->passwordrepeat;
    }
    public function setPasswordrepeat($passwordrepeat){
        $this->passwordrepeat = $passwordrepeat;
        return $this;
    }


    /**
     * Set modifiedUser
     *
     * @param integer $modifiedUser
     * @return User
     */
    public function setModifiedUser($modifiedUser)
    {
        $this->modifiedUser = $modifiedUser;
    
        return $this;
    }

    /**
     * Get modifiedUser
     *
     * @return integer 
     */
    public function getModifiedUser()
    {
        return $this->modifiedUser;
    }

    /**
     * Add groups
     *
     * @param Acme\UserBundle\Entity\Group $groups
     * @return User
     */
    public function addGroup(\Acme\UserBundle\Entity\Group $groups)
    {
        $this->groups[] = $groups;
    
        return $this;
    }

    /**
     * Remove groups
     *
     * @param Acme\UserBundle\Entity\Group $groups
     */
    public function removeGroup(\Acme\UserBundle\Entity\Group $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Set isUser
     *
     * @param boolean $isUser
     * @return User
     */
    public function setIsUser($isUser)
    {
        $this->isUser = $isUser;
    
        return $this;
    }

    /**
     * Get isUser
     *
     * @return boolean 
     */
    public function getIsUser()
    {
        return $this->isUser;
    }
}