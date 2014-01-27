<?php

namespace NoizuLabs\Core\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModeratedStrings
 *
 * @ORM\Table(name="moderated_strings")
 * @ORM\Entity
 */
class ModeratedStrings extends \NoizuLabs\Core\Doctrine\Entity
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
     * @var \NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs
     *
     * @ORM\ManyToOne(targetEntity="NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="approved_text_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $approvedText;

    /**
     * @var \NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs
     *
     * @ORM\ManyToOne(targetEntity="NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pending_text_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $pendingText;

    /**
     * @var \NoizuLabs\Core\Doctrine\Entity\ModeratedStringTypes
     *
     * @ORM\ManyToOne(targetEntity="NoizuLabs\Core\Doctrine\Entity\ModeratedStringTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="str_type", referencedColumnName="id", nullable=true)
     * })
     */
    private $strType;


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
     * Set approvedText
     *
     * @param \NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs $approvedText
     * @return ModeratedStrings
     */
    public function setApprovedText(\NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs $approvedText = null)
    {
        $this->approvedText = $approvedText;

        return $this;
    }

    /**
     * Get approvedText
     *
     * @return \NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs
     */
    public function getApprovedText()
    {
        return $this->approvedText;
    }

    /**
     * Set pendingText
     *
     * @param \NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs $pendingText
     * @return ModeratedStrings
     */
    public function setPendingText(\NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs $pendingText = null)
    {
        $this->pendingText = $pendingText;

        return $this;
    }

    /**
     * Get pendingText
     *
     * @return \NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs
     */
    public function getPendingText()
    {
        return $this->pendingText;
    }

    /**
     * Set strType
     *
     * @param \NoizuLabs\Core\Doctrine\Entity\ModeratedStringTypes $strType
     * @return ModeratedStrings
     */
    public function setStrType(\NoizuLabs\Core\Doctrine\Entity\ModeratedStringTypes $strType = null)
    {
        $this->strType = $strType;

        return $this;
    }

    /**
     * Get strType
     *
     * @return \NoizuLabs\Core\Doctrine\Entity\ModeratedStringTypes
     */
    public function getStrType()
    {
        return $this->strType;
    }
}
