<?php

namespace NoizuLabs\Core\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmailTemplateQueueData
 *
 * @ORM\Table(name="email_template_queue_data")
 * @ORM\Entity
 */
class EmailTemplateQueueData extends \NoizuLabs\Core\Doctrine\Entity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="string", length=1024, precision=0, scale=0, nullable=true, unique=false)
     */
    private $data;

    /**
     * @var string
     *
     * @ORM\Column(name="sent_data", type="string", length=1024, precision=0, scale=0, nullable=true, unique=false)
     */
    private $sentData;

    /**
     * @var string
     *
     * @ORM\Column(name="errors", type="string", length=1024, precision=0, scale=0, nullable=true, unique=false)
     */
    private $errors;

    /**
     * @var \NoizuLabs\Core\Doctrine\Entity\EmailTemplateQueue
     *
     * @ORM\ManyToOne(targetEntity="NoizuLabs\Core\Doctrine\Entity\EmailTemplateQueue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="email_template_queue_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $emailTemplateQueue;


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
     * Set data
     *
     * @param string $data
     * @return EmailTemplateQueueData
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set sentData
     *
     * @param string $sentData
     * @return EmailTemplateQueueData
     */
    public function setSentData($sentData)
    {
        $this->sentData = $sentData;

        return $this;
    }

    /**
     * Get sentData
     *
     * @return string
     */
    public function getSentData()
    {
        return $this->sentData;
    }

    /**
     * Set errors
     *
     * @param string $errors
     * @return EmailTemplateQueueData
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * Get errors
     *
     * @return string
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set emailTemplateQueue
     *
     * @param \NoizuLabs\Core\Doctrine\Entity\EmailTemplateQueue $emailTemplateQueue
     * @return EmailTemplateQueueData
     */
    public function setEmailTemplateQueue(\NoizuLabs\Core\Doctrine\Entity\EmailTemplateQueue $emailTemplateQueue = null)
    {
        $this->emailTemplateQueue = $emailTemplateQueue;

        return $this;
    }

    /**
     * Get emailTemplateQueue
     *
     * @return \NoizuLabs\Core\Doctrine\Entity\EmailTemplateQueue
     */
    public function getEmailTemplateQueue()
    {
        return $this->emailTemplateQueue;
    }
}
