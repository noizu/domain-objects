<?php
namespace NoizuLabs\Core\DomainObject\Repository;
use NoizuLabs\Core\DomainObject as DomainObject;

class TemplatedEmailQueue extends DomainObject\Repository
{
    const STATUS_NOT_READY = 0;
    const STATUS_SENT = 1;
    const STATUS_PENDING = 2;
    const STATUS_ERROR = 3;
    const STATUS_PROCESSING = 4;
    const STATUS_HALTED = 5;
    const STATUS_OUTGOING_DISABLED = 6;

    const TEMPLATE_EMAIL_VERIFICATION = 1;
    const TEMPLATE_USERNAME_RECOVERY = 2;
    const TEMPLATE_PASSWORD_RECOVERY = 3;
    const TEMPLATE_REGISTRATION = 4;

	function __construct()
	{
	    parent::__construct();
	}

	function __destruct()
	{

	}

	public function getQueuedEmail($id)
	{
	    $entityManager = $this->container['EntityManager'];
	    $emqc = $this->container['EntityClass_EmailTemplateQueue'] = "";
	    $query = $entityManager->createQuery("
	           SELECT e
	            FROM
	               $emqc as e
	            WHERE
	                e.id  = :id
	        ");
        $query->setParameters(array(
            ':id' => $id,
        ));
        $query->setMaxResults(1);
        $entities = $query->getResult();
        if($entities) {
            $queuedEmail = $this->container['Do_QueuedTemplatedEmail'];
            $queuedEmail->load($entities[0]);
            return $queuedEmail;
        }
    }

    public function getFailedToSend($limit, $raw = false)
    {
        return $this->getByStatus(self::STATUS_ERROR, $limit, $raw);
    }

    public function getReadyToSend($limit, $raw = false)
    {
        return $this->getByStatus(self::STATUS_PENDING, $limit, $raw);
    }

    public function getByStatus($status, $limit, $raw = false)
    {
        $entityManager = $this->container['EntityManager'];
        $emqc = $this->container['EntityClass_EmailTemplateQueue'] = "";
        $query = $entityManager->createQuery("
               SELECT e
                FROM
                    $emqc as e
                WHERE
                    e.status  = :status
            ");
        $query->setParameters(array(
            ':status' => $status,
        ));
        $query->setMaxResults($limit);
        $entities = $query->getResult();
        if($entities) {
            if($raw) {
                return $entities;
            } else {
                $out = array();
                foreach($entities as &$e)
                {
                    $queuedEmail = $this->container['Do_QueuedTemplatedEmail'];
                    $queuedEmail->load($e);
                    $out[] = $queuedEmail;
                }
                return $out;
            }
        }
    }

    public function queueEmail($template, $user, $attributes)
    {
        $entityManager = $this->container['EntityManager'];
        /*@var $queuedEmail DomainObject\QueuedTemplatedEmail */
        $queuedEmail = $this->container['Do_QueuedTemplatedEmail'];
        $queuedEmail->setDefaultFields();
        $queuedEmail->setEmailTemplate($template);
        $queuedEmail->setSite();
        $queuedEmail->setUser($user);
        $queuedEmail->setStatus(self::STATUS_PENDING);
        $queuedEmail->bindData($attributes);
        $queuedEmail->save();
        return $queuedEmail;
    }
}
