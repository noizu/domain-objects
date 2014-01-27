<?php
namespace NoizuLabs\Core\Doctrine\Entity;





use Doctrine\ORM\Mapping as ORM;

/**
 * ModeratedStringChangeLogs
 *
 * @ORM\Table(name="moderated_string_change_logs")
 * @ORM\Entity
 */
class ModeratedStringChangeLogs
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
     * @var string
     *
     * @ORM\Column(name="string", type="string", length=1024, nullable=false)
     */
    private $string;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="event_time_stamp", type="datetime", nullable=false)
     */
    private $eventTimeStamp;

    /**
     * @var string
     *
     * @ORM\Column(name="autoflag", type="blob", nullable=false)
     */
    private $autoflag;

    /**
     * @var \ModeratedStrings
     *
     * @ORM\ManyToOne(targetEntity="ModeratedStrings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="moderated_string_id", referencedColumnName="id")
     * })
     */
    private $moderatedString;

    /**
     * @var \ModeratedStringActions
     *
     * @ORM\ManyToOne(targetEntity="ModeratedStringActions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="action_id", referencedColumnName="id")
     * })
     */
    private $action;

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
