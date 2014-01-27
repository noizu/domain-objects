<?php

namespace NoizuLabs\Core\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModeratedStringActions
 *
 * @ORM\Table(name="moderated_string_actions")
 * @ORM\Entity
 */
class ModeratedStringActions extends \NoizuLabs\Core\Doctrine\Entity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="smallint", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="mod_action", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $modAction;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $description;


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
     * Set modAction
     *
     * @param string $modAction
     * @return ModeratedStringActions
     */
    public function setModAction($modAction)
    {
        $this->modAction = $modAction;

        return $this;
    }

    /**
     * Get modAction
     *
     * @return string
     */
    public function getModAction()
    {
        return $this->modAction;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return ModeratedStringActions
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
