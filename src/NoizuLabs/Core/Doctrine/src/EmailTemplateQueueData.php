<?php
namespace NoizuLabs\Core\Doctrine\Entity;





use Doctrine\ORM\Mapping as ORM;

/**
 * EmailTemplateQueueData
 *
 * @ORM\Table(name="email_template_queue_data")
 * @ORM\Entity
 */
class EmailTemplateQueueData
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
     * @ORM\Column(name="data", type="string", length=1024, nullable=true)
     */
    private $data;

    /**
     * @var string
     *
     * @ORM\Column(name="sent_data", type="string", length=1024, nullable=true)
     */
    private $sentData;

    /**
     * @var string
     *
     * @ORM\Column(name="errors", type="string", length=1024, nullable=true)
     */
    private $errors;

    /**
     * @var \EmailTemplateQueue
     *
     * @ORM\ManyToOne(targetEntity="EmailTemplateQueue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="email_template_queue_id", referencedColumnName="id")
     * })
     */
    private $emailTemplateQueue;


}
