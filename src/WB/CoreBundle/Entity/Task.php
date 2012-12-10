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
     * @ORM\ManyToMany(targetEntity="SfGuardUser", inversedBy="task")
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
    
}
