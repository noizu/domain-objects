<?php

namespace NoizuLabs\Core\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmailTemplateQueue
 *
 * @ORM\Table(name="email_template_queue")
 * @ORM\Entity
 */
class EmailTemplateQueue extends \NoizuLabs\Core\Doctrine\Entity
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
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint", precision=0, scale=0, nullable=false, unique=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_updated", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $lastUpdated;

    /**
     * @var \NoizuLabs\Core\Doctrine\Entity\EmailTemplates
     *
     * @ORM\ManyToOne(targetEntity="NoizuLabs\Core\Doctrine\Entity\EmailTemplates")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="email_template_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $emailTemplate;

    /**
     * @var \NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs
     *
     * @ORM\ManyToOne(targetEntity="NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sent_subject_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $sentSubject;

    /**
     * @var \NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs
     *
     * @ORM\ManyToOne(targetEntity="NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sent_template_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $sentTemplate;

    /**
     * @var \NoizuLabs\Core\Doctrine\Entity\Sites
     *
     * @ORM\ManyToOne(targetEntity="NoizuLabs\Core\Doctrine\Entity\Sites")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="site_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $site;

    /**
     * @var \NoizuLabs\Core\Doctrine\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="NoizuLabs\Core\Doctrine\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $user;


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
     * Set status
     *
     * @param integer $status
     * @return EmailTemplateQueue
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set lastUpdated
     *
     * @param \DateTime $lastUpdated
     * @return EmailTemplateQueue
     */
    public function setLastUpdated($lastUpdated)
    {
        $this->lastUpdated = $lastUpdated;

        return $this;
    }

    /**
     * Get lastUpdated
     *
     * @return \DateTime
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * Set emailTemplate
     *
     * @param \NoizuLabs\Core\Doctrine\Entity\EmailTemplates $emailTemplate
     * @return EmailTemplateQueue
     */
    public function setEmailTemplate(\NoizuLabs\Core\Doctrine\Entity\EmailTemplates $emailTemplate = null)
    {
        $this->emailTemplate = $emailTemplate;

        return $this;
    }

    /**
     * Get emailTemplate
     *
     * @return \NoizuLabs\Core\Doctrine\Entity\EmailTemplates
     */
    public function getEmailTemplate()
    {
        return $this->emailTemplate;
    }

    /**
     * Set sentSubject
     *
     * @param \NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs $sentSubject
     * @return EmailTemplateQueue
     */
    public function setSentSubject(\NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs $sentSubject = null)
    {
        $this->sentSubject = $sentSubject;

        return $this;
    }

    /**
     * Get sentSubject
     *
     * @return \NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs
     */
    public function getSentSubject()
    {
        return $this->sentSubject;
    }

    /**
     * Set sentTemplate
     *
     * @param \NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs $sentTemplate
     * @return EmailTemplateQueue
     */
    public function setSentTemplate(\NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs $sentTemplate = null)
    {
        $this->sentTemplate = $sentTemplate;

        return $this;
    }

    /**
     * Get sentTemplate
     *
     * @return \NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs
     */
    public function getSentTemplate()
    {
        return $this->sentTemplate;
    }

    /**
     * Set site
     *
     * @param \NoizuLabs\Core\Doctrine\Entity\Sites $site
     * @return EmailTemplateQueue
     */
    public function setSite(\NoizuLabs\Core\Doctrine\Entity\Sites $site = null)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return \NoizuLabs\Core\Doctrine\Entity\Sites
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set user
     *
     * @param \NoizuLabs\Core\Doctrine\Entity\Users $user
     * @return EmailTemplateQueue
     */
    public function setUser(\NoizuLabs\Core\Doctrine\Entity\Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \NoizuLabs\Core\Doctrine\Entity\Users
     */
    public function getUser()
    {
        return $this->user;
    }
}
