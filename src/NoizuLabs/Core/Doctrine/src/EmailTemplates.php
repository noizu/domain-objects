<?php
namespace NoizuLabs\Core\Doctrine\Entity;





use Doctrine\ORM\Mapping as ORM;

/**
 * EmailTemplates
 *
 * @ORM\Table(name="email_templates")
 * @ORM\Entity
 */
class EmailTemplates
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \ModeratedStrings
     *
     * @ORM\ManyToOne(targetEntity="ModeratedStrings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="friendly_name", referencedColumnName="id")
     * })
     */
    private $friendlyName;

    /**
     * @var \ModeratedStrings
     *
     * @ORM\ManyToOne(targetEntity="ModeratedStrings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subject", referencedColumnName="id")
     * })
     */
    private $subject;

    /**
     * @var \ModeratedStrings
     *
     * @ORM\ManyToOne(targetEntity="ModeratedStrings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="template", referencedColumnName="id")
     * })
     */
    private $template;


}
