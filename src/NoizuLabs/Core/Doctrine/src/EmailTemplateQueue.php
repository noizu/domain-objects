<?php
namespace NoizuLabs\Core\Doctrine\Entity;





use Doctrine\ORM\Mapping as ORM;

/**
 * EmailTemplateQueue
 *
 * @ORM\Table(name="email_template_queue")
 * @ORM\Entity
 */
class EmailTemplateQueue
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
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint", nullable=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_updated", type="datetime", nullable=false)
     */
    private $lastUpdated;

    /**
     * @var \EmailTemplates
     *
     * @ORM\ManyToOne(targetEntity="EmailTemplates")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="email_template_id", referencedColumnName="id")
     * })
     */
    private $emailTemplate;

    /**
     * @var \ModeratedStringChangeLogs
     *
     * @ORM\ManyToOne(targetEntity="ModeratedStringChangeLogs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sent_subject_id", referencedColumnName="id")
     * })
     */
    private $sentSubject;

    /**
     * @var \ModeratedStringChangeLogs
     *
     * @ORM\ManyToOne(targetEntity="ModeratedStringChangeLogs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sent_template_id", referencedColumnName="id")
     * })
     */
    private $sentTemplate;

    /**
     * @var \Sites
     *
     * @ORM\ManyToOne(targetEntity="Sites")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="site_id", referencedColumnName="id")
     * })
     */
    private $site;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


}
