<?php

namespace NoizuLabs\Core\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModeratedStringTypes
 *
 * @ORM\Table(name="moderated_string_types")
 * @ORM\Entity
 */
class ModeratedStringTypes extends \NoizuLabs\Core\Doctrine\Entity
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
     * @ORM\Column(name="string_type", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $stringType;

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
     * Set stringType
     *
     * @param string $stringType
     * @return ModeratedStringTypes
     */
    public function setStringType($stringType)
    {
        $this->stringType = $stringType;

        return $this;
    }

    /**
     * Get stringType
     *
     * @return string
     */
    public function getStringType()
    {
        return $this->stringType;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return ModeratedStringTypes
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
