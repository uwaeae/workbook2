<?php

namespace WB\MessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WB\CoreBundle\Entity\Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity
 */
class Message
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
     * @var integer $parent
     *
     * @ORM\Column(name="parent", type="bigint", nullable=true)
     */
    private $parent;

    /**
     * @var integer $reciver
     *
     * @ORM\Column(name="reciver", type="bigint", nullable=true)
     */
    private $reciver;

    /**
     * @var string $body
     *
     * @ORM\Column(name="body", type="text", nullable=true)
     */
    private $body;

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
     * @var Job
     *
     * @ORM\ManyToOne(targetEntity="WB\CoreBundle\Entity\Job")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="job_id", referencedColumnName="id")
     * })
     */
    private $job;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Acme\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sender", referencedColumnName="id")
     * })
     */
    private $sender;


}
