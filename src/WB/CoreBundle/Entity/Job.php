<?php

namespace WB\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WB\CoreBundle\Entity\Job
 *
 * @ORM\Table(name="job")
 * @ORM\Entity
 */
class Job
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
     * @var string $contactPerson
     *
     * @ORM\Column(name="contact_person", type="string", length=255, nullable=true)
     */
    private $contactPerson;

    /**
     * @var string $contactInfo
     *
     * @ORM\Column(name="contact_info", type="string", length=255, nullable=true)
     */
    private $contactInfo;

    /**
     * @var \DateTime $end
     *
     * @ORM\Column(name="end", type="datetime", nullable=false)
     */
    private $end;

    /**
     * @var \DateTime $start
     *
     * @ORM\Column(name="start", type="datetime", nullable=true)
     */
    private $start;

    /**
     * @var \DateTime $timeed
     *
     * @ORM\Column(name="timeed", type="datetime", nullable=true)
     */
    private $timeed;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var boolean $timeinterval
     *
     * @ORM\Column(name="timeinterval", type="boolean", nullable=true)
     */
    private $timeinterval;

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
     * @ORM\ManyToMany(targetEntity="File", mappedBy="job")
     */
    private $file;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Invoice", inversedBy="job")
     * @ORM\JoinTable(name="job_invoice",
     *   joinColumns={
     *     @ORM\JoinColumn(name="job_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="invoice_id", referencedColumnName="id")
     *   }
     * )
     */
    private $invoice;

    /**
     * @var JobState
     *
     * @ORM\ManyToOne(targetEntity="JobState")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="job_state_id", referencedColumnName="id")
     * })
     */
    private $jobState;

    /**
     * @var JobType
     *
     * @ORM\ManyToOne(targetEntity="JobType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="job_type_id", referencedColumnName="id")
     * })
     */
    private $jobType;

    /**
     * @var Store
     *
     * @ORM\ManyToOne(targetEntity="Store")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="store_id", referencedColumnName="id")
     * })
     */
    private $store;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->file = new \Doctrine\Common\Collections\ArrayCollection();
        $this->invoice = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}
