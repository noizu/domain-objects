<?php
namespace NoizuLabs\Core\Doctrine\Entity;





use Doctrine\ORM\Mapping as ORM;

/**
 * ModeratedStringActions
 *
 * @ORM\Table(name="moderated_string_actions")
 * @ORM\Entity
 */
class ModeratedStringActions
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="smallint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="mod_action", type="string", length=255, nullable=false)
     */
    private $modAction;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;


}
