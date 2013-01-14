<?php

namespace WB\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WB\CoreBundle\Entity\Task
 *
 * @ORM\Table(name="task")
 * @ORM\Entity
 */
class Task
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
     * @var \DateTime $start
     *
     * @ORM\Column(name="start", type="datetime", nullable=true)
     */
    private $start;

    /**
     * @var \DateTime $end
     *
     * @ORM\Column(name="end", type="datetime", nullable=true)
     */
    private $end;

    /**
     * @var boolean $scheduled
     *
     * @ORM\Column(name="scheduled", type="boolean", nullable=true)
     */
    private $scheduled;

    /**
     * @var integer $break
     *
     * @ORM\Column(name="break", type="bigint", nullable=true)
     */
    private $break;

    /**
     * @var float $overtime
     *
     * @ORM\Column(name="overtime", type="decimal", nullable=true)
     */
    private $overtime;

    /**
     * @var string $info
     *
     * @ORM\Column(name="info", type="text", nullable=true)
     */
    private $info;

    /**
     * @var integer $approach
     *
     * @ORM\Column(name="approach", type="bigint", nullable=true)
     */
    private $approach;

    /**
     * @var float $correctionTime
     *
     * @ORM\Column(name="correction_time", type="decimal", nullable=true)
     */
    private $correctionTime;

    /**
     * @var string $correctionInfo
     *
     * @ORM\Column(name="correction_info", type="text", nullable=true)
     */
    private $correctionInfo;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var integer $createdFrom
     *
     * @ORM\Column(name="created_from", type="bigint", nullable=true)
     */
    private $createdFrom;

    /**
     * @var \DateTime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var integer $updatedFrom
     *
     * @ORM\Column(name="updated_from", type="bigint", nullable=true)
     */
    private $updatedFrom;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Acme\UserBundle\Entity\User", inversedBy="task")
     * @ORM\JoinTable(name="task_user",
     *   joinColumns={
     *     @ORM\JoinColumn(name="task_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *   }
     * )
     */
    private $user;

    /**
     * @var Job
     *
     * @ORM\ManyToOne(targetEntity="Job")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="job_id", referencedColumnName="id")
     * })
     */
    private $job;

    /**
     * @var TaskType
     *
     * @ORM\ManyToOne(targetEntity="TaskType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="task_type_id", referencedColumnName="id")
     * })
     */
    private $taskType;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set start
     *
     * @param \DateTime $start
     * @return Task
     */
    public function setStart($start)
    {
        $this->start = $start;
    
        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime 
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     * @return Task
     */
    public function setEnd($end)
    {
        $this->end = $end;
    
        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime 
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set scheduled
     *
     * @param boolean $scheduled
     * @return Task
     */
    public function setScheduled($scheduled)
    {
        $this->scheduled = $scheduled;
    
        return $this;
    }

    /**
     * Get scheduled
     *
     * @return boolean 
     */
    public function getScheduled()
    {
        return $this->scheduled;
    }

    /**
     * Set break
     *
     * @param integer $break
     * @return Task
     */
    public function setBreak($break)
    {
        $this->break = $break;
    
        return $this;
    }

    /**
     * Get break
     *
     * @return integer 
     */
    public function getBreak()
    {
        return $this->break;
    }

    /**
     * Set overtime
     *
     * @param float $overtime
     * @return Task
     */
    public function setOvertime($overtime)
    {
        $this->overtime = $overtime;
    
        return $this;
    }

    /**
     * Get overtime
     *
     * @return float 
     */
    public function getOvertime()
    {
        return $this->overtime;
    }

    /**
     * Set info
     *
     * @param string $info
     * @return Task
     */
    public function setInfo($info)
    {
        $this->info = $info;
    
        return $this;
    }

    /**
     * Get info
     *
     * @return string 
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set approach
     *
     * @param integer $approach
     * @return Task
     */
    public function setApproach($approach)
    {
        $this->approach = $approach;
    
        return $this;
    }

    /**
     * Get approach
     *
     * @return integer 
     */
    public function getApproach()
    {
        return $this->approach;
    }

    /**
     * Set correctionTime
     *
     * @param float $correctionTime
     * @return Task
     */
    public function setCorrectionTime($correctionTime)
    {
        $this->correctionTime = $correctionTime;
    
        return $this;
    }

    /**
     * Get correctionTime
     *
     * @return float 
     */
    public function getCorrectionTime()
    {
        return $this->correctionTime;
    }

    /**
     * Set correctionInfo
     *
     * @param string $correctionInfo
     * @return Task
     */
    public function setCorrectionInfo($correctionInfo)
    {
        $this->correctionInfo = $correctionInfo;
    
        return $this;
    }

    /**
     * Get correctionInfo
     *
     * @return string 
     */
    public function getCorrectionInfo()
    {
        return $this->correctionInfo;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Task
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
     * Set createdFrom
     *
     * @param integer $createdFrom
     * @return Task
     */
    public function setCreatedFrom($createdFrom)
    {
        $this->createdFrom = $createdFrom;
    
        return $this;
    }

    /**
     * Get createdFrom
     *
     * @return integer 
     */
    public function getCreatedFrom()
    {
        return $this->createdFrom;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Task
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
     * Set updatedFrom
     *
     * @param integer $updatedFrom
     * @return Task
     */
    public function setUpdatedFrom($updatedFrom)
    {
        $this->updatedFrom = $updatedFrom;
    
        return $this;
    }

    /**
     * Get updatedFrom
     *
     * @return integer 
     */
    public function getUpdatedFrom()
    {
        return $this->updatedFrom;
    }

    /**
     * Add user
     *
     * @param Acme\UserBundle\Entity\User $user
     * @return Task
     */
    public function addUser(\Acme\UserBundle\Entity\User $user)
    {
        $this->user[] = $user;
    
        return $this;
    }

    /**
     * Remove user
     *
     * @param Acme\UserBundle\Entity\User $user
     */
    public function removeUser(\Acme\UserBundle\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set job
     *
     * @param WB\CoreBundle\Entity\Job $job
     * @return Task
     */
    public function setJob(\WB\CoreBundle\Entity\Job $job = null)
    {
        $this->job = $job;
    
        return $this;
    }

    /**
     * Get job
     *
     * @return WB\CoreBundle\Entity\Job 
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set taskType
     *
     * @param WB\CoreBundle\Entity\TaskType $taskType
     * @return Task
     */
    public function setTaskType(\WB\CoreBundle\Entity\TaskType $taskType = null)
    {
        $this->taskType = $taskType;
    
        return $this;
    }

    /**
     * Get taskType
     *
     * @return WB\CoreBundle\Entity\TaskType 
     */
    public function getTaskType()
    {
        return $this->taskType;
    }
}