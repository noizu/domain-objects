<?php

namespace NoizuLabs\Core\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmailTemplates
 *
 * @ORM\Table(name="email_templates")
 * @ORM\Entity
 */
class EmailTemplates extends \NoizuLabs\Core\Doctrine\Entity
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
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $created;

    /**
     * @var \NoizuLabs\Core\Doctrine\Entity\ModeratedStrings
     *
     * @ORM\ManyToOne(targetEntity="NoizuLabs\Core\Doctrine\Entity\ModeratedStrings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="friendly_name", referencedColumnName="id", nullable=true)
     * })
     */
    private $friendlyName;

    /**
     * @var \NoizuLabs\Core\Doctrine\Entity\ModeratedStrings
     *
     * @ORM\ManyToOne(targetEntity="NoizuLabs\Core\Doctrine\Entity\ModeratedStrings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subject", referencedColumnName="id", nullable=true)
     * })
     */
    private $subject;

    /**
     * @var \NoizuLabs\Core\Doctrine\Entity\ModeratedStrings
     *
     * @ORM\ManyToOne(targetEntity="NoizuLabs\Core\Doctrine\Entity\ModeratedStrings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="template", referencedColumnName="id", nullable=true)
     * })
     */
    private $template;


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
     * Set created
     *
     * @param \DateTime $created
     * @return EmailTemplates
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set friendlyName
     *
     * @param \NoizuLabs\Core\Doctrine\Entity\ModeratedStrings $friendlyName
     * @return EmailTemplates
     */
    public function setFriendlyName(\NoizuLabs\Core\Doctrine\Entity\ModeratedStrings $friendlyName = null)
    {
        $this->friendlyName = $friendlyName;

        return $this;
    }

    /**
     * Get friendlyName
     *
     * @return \NoizuLabs\Core\Doctrine\Entity\ModeratedStrings
     */
    public function getFriendlyName()
    {
        return $this->friendlyName;
    }

    /**
     * Set subject
     *
     * @param \NoizuLabs\Core\Doctrine\Entity\ModeratedStrings $subject
     * @return EmailTemplates
     */
    public function setSubject(\NoizuLabs\Core\Doctrine\Entity\ModeratedStrings $subject = null)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return \NoizuLabs\Core\Doctrine\Entity\ModeratedStrings
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set template
     *
     * @param \NoizuLabs\Core\Doctrine\Entity\ModeratedStrings $template
     * @return EmailTemplates
     */
    public function setTemplate(\NoizuLabs\Core\Doctrine\Entity\ModeratedStrings $template = null)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return \NoizuLabs\Core\Doctrine\Entity\ModeratedStrings
     */
    public function getTemplate()
    {
        return $this->template;
    }
}
