<?php
namespace NoizuLabs\Core\Doctrine\Entity;





use Doctrine\ORM\Mapping as ORM;

/**
 * ModeratedStrings
 *
 * @ORM\Table(name="moderated_strings")
 * @ORM\Entity
 */
class ModeratedStrings
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
     * @var \ModeratedStringChangeLogs
     *
     * @ORM\ManyToOne(targetEntity="ModeratedStringChangeLogs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="approved_text_id", referencedColumnName="id")
     * })
     */
    private $approvedText;

    /**
     * @var \ModeratedStringChangeLogs
     *
     * @ORM\ManyToOne(targetEntity="ModeratedStringChangeLogs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pending_text_id", referencedColumnName="id")
     * })
     */
    private $pendingText;

    /**
     * @var \ModeratedStringTypes
     *
     * @ORM\ManyToOne(targetEntity="ModeratedStringTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="str_type", referencedColumnName="id")
     * })
     */
    private $strType;


}
