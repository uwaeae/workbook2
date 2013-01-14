<?php

namespace WB\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WB\CoreBundle\Entity\File
 *
 * @ORM\Table(name="file")
 * @ORM\Entity
 */
class File
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=64, nullable=false)
     */
    private $name;

    /**
     * @var string $file
     *
     * @ORM\Column(name="file", type="string", length=255, nullable=true)
     */
    private $file;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Job", inversedBy="file")
     * @ORM\JoinTable(name="file_job",
     *   joinColumns={
     *     @ORM\JoinColumn(name="file_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="job_id", referencedColumnName="id")
     *   }
     * )
     */
    private $job;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->job = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return File
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
     * Set file
     *
     * @param string $file
     * @return File
     */
    public function setFile($file)
    {
        $this->file = $file;
    
        return $this;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Add job
     *
     * @param WB\CoreBundle\Entity\Job $job
     * @return File
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