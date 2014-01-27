<?php

namespace NoizuLabs\Core\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModeratedStringChangeLogs
 *
 * @ORM\Table(name="moderated_string_change_logs")
 * @ORM\Entity
 */
class ModeratedStringChangeLogs extends \NoizuLabs\Core\Doctrine\Entity
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
     * @ORM\Column(name="string", type="string", length=1024, precision=0, scale=0, nullable=false, unique=false)
     */
    private $string;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="event_time_stamp", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $eventTimeStamp;

    /**
     * @var string
     *
     * @ORM\Column(name="autoflag", type="blob", precision=0, scale=0, nullable=false, unique=false)
     */
    private $autoflag;

    /**
     * @var \NoizuLabs\Core\Doctrine\Entity\ModeratedStrings
     *
     * @ORM\ManyToOne(targetEntity="NoizuLabs\Core\Doctrine\Entity\ModeratedStrings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="moderated_string_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $moderatedString;

    /**
     * @var \NoizuLabs\Core\Doctrine\Entity\ModeratedStringActions
     *
     * @ORM\ManyToOne(targetEntity="NoizuLabs\Core\Doctrine\Entity\ModeratedStringActions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="action_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $action;

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
     * Set string
     *
     * @param string $string
     * @return ModeratedStringChangeLogs
     */
    public function setString($string)
    {
        $this->string = $string;

        return $this;
    }

    /**
     * Get string
     *
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * Set eventTimeStamp
     *
     * @param \DateTime $eventTimeStamp
     * @return ModeratedStringChangeLogs
     */
    public function setEventTimeStamp($eventTimeStamp)
    {
        $this->eventTimeStamp = $eventTimeStamp;

        return $this;
    }

    /**
     * Get eventTimeStamp
     *
     * @return \DateTime
     */
    public function getEventTimeStamp()
    {
        return $this->eventTimeStamp;
    }

    /**
     * Set autoflag
     *
     * @param string $autoflag
     * @return ModeratedStringChangeLogs
     */
    public function setAutoflag($autoflag)
    {
        $this->autoflag = $autoflag;

        return $this;
    }

    /**
     * Get autoflag
     *
     * @return string
     */
    public function getAutoflag()
    {
        return $this->autoflag;
    }

    /**
     * Set moderatedString
     *
     * @param \NoizuLabs\Core\Doctrine\Entity\ModeratedStrings $moderatedString
     * @return ModeratedStringChangeLogs
     */
    public function setModeratedString(\NoizuLabs\Core\Doctrine\Entity\ModeratedStrings $moderatedString = null)
    {
        $this->moderatedString = $moderatedString;

        return $this;
    }

    /**
     * Get moderatedString
     *
     * @return \NoizuLabs\Core\Doctrine\Entity\ModeratedStrings
     */
    public function getModeratedString()
    {
        return $this->moderatedString;
    }

    /**
     * Set action
     *
     * @param \NoizuLabs\Core\Doctrine\Entity\ModeratedStringActions $action
     * @return ModeratedStringChangeLogs
     */
    public function setAction(\NoizuLabs\Core\Doctrine\Entity\ModeratedStringActions $action = null)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return \NoizuLabs\Core\Doctrine\Entity\ModeratedStringActions
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set user
     *
     * @param \NoizuLabs\Core\Doctrine\Entity\Users $user
     * @return ModeratedStringChangeLogs
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
