<?php
namespace NoizuLabs\Core\DomainObject;

use \NoizuLabs\Core\Doctrine\Entity;

class EmailTemplate extends \NoizuLabs\Core\DomainObject
{
    protected $siteEntity = null;
    protected $siteLoaded = false;

    protected function siteInit()
    {
        if(!$this->siteLoaded) {
            $site = $this->getSite();
            if($site && $this->entity && $this->entity->getId())
            {
                // Load Site Entity if exists, else initialize new
                $entityManager = $this->container['EntityManager'];
                $query = $entityManager->createQuery('
	            SELECT t
	            FROM
	                \NoizuLabs\Core\Doctrine\Entity\SiteEmailTemplates as t
	            WHERE
	               t.site = :site AND
                   t.emailTemplate = :template
    	        ');

                $query->setParameters(array(
                    ':site' => $site,
                    ':template' => $this->entity
                ));
                $entities = $query->getResult();
                if(count($entities)) {
                    $this->siteEntity = $entities[0];
                    $this->siteLoaded = true;
                } else {
                    $this->siteEntity = $this->container['Entity_SiteEmailTemplates'];
                    $this->siteEntity->setSite($site);
                    $this->siteEntity->setEmailTemplate($this->entity);
                    $this->siteLoaded = true;
                }
            } else {
                $this->siteEntity = $this->container['Entity_SiteEmailTemplates'];
                $this->siteEntity->setSite($site);
                $this->siteEntity->setEmailTemplate($this->entity);
                $this->siteLoaded = true;
            }
            $this->siteLoaded = true;
        }
    }


    //==============================
    // Boiler Plate
    //==============================
    public $requiredFields = array("friendlyName", "subject", "template");
    public $internalFields = array();
    public $optionalFields = array();
    public $defaultFields = array(
    );


    public function save($flush  = true)
    {
        // Username must be unique
        return parent::save($flush);
    }

    protected function init()
    {
        if($this->loaded == false)
        {
            $this->entity = $this->container['Entity_EmailTemplates'];
            $this->loaded = true;
        }
    }



    public function load($mixed)
    {
        $this->loaded = false;
        $this->siteLoaded = false;
        $this->entity = null;
        $this->siteEntity = null;

        if(is_object($mixed))
        {
            $this->entity = $mixed;
            $this->loaded = true;
            $this->siteInit();
        } else  if(is_int($mixed))
        {
            $r = $this->container['Do_Repository_EmailTemplates'];
            $this->entity = $r->getTemplate($mixed, true);
            if($this->entity) {
                $this->loaded = true;
            }
        } else if(is_string($mixed)) {
            die('todo load by friendly name');
        }
        return $this->loaded;
    }


    function __construct()
    {
        parent::__construct();
    }

    function __destruct()
    {
    }

    //=====================================
    // Getters Setters
    //=====================================
    public function getId()
    {
        return $this->getField('id');
    }

    public function getFriendlyName()
    {
        return $this->getField('friendlyName');
    }

    public function getDefaultSubject()
    {
        return $this->getField('subject');
    }

    public function getDefaultTemplate()
    {
        return $this->getField('template');
    }

    public function getSubject()
    {
        return $this->getSiteField('subject');
    }

    public function getTemplate()
    {
        return $this->getSiteField('template');
    }

    public function getFinalSubject()
    {
        return $this->getSubject() ? $this->getSubject() : $this->getDefaultSubject();
    }

    public function getFinalTemplate()
    {
        return $this->getTemplate() ? $this->getTemplate() : $this->getDefaultTemplate();
    }

    public function setFriendlyName($value, $action = null)
    {
        $this->setModeratedStringFieldAutoApprove(
            "friendlyName",
            \NoizuLabs\Core\DomainObject\ModeratedString::EMAIL_TEMPLATE_NAME ,
            $value,
            array('action' => $action));
    }
    public function setDefaultTemplate($value, $action = null)
    {
        $this->setModeratedStringFieldAutoApprove(
            "template",
            \NoizuLabs\Core\DomainObject\ModeratedString::EMAIL_TEMPLATE_TEMPLATE ,
            $value,
            array('action' => $action));
    }
    public function setDefaultSubject($value, $action = null)
    {
        $this->setModeratedStringFieldAutoApprove(
            "subject",
            \NoizuLabs\Core\DomainObject\ModeratedString::EMAIL_TEMPLATE_SUBJECT,
            $value,
            array('action' => $action));
    }
    public function setTemplate($value, $action = null)
    {
        $this->setModeratedStringSiteFieldAutoApprove(
            "template",
            \NoizuLabs\Core\DomainObject\ModeratedString::EMAIL_TEMPLATE_TEMPLATE ,
            $value,
            array('action' => $action, 'empty' => true));
    }
    public function setSubject($value, $action = null)
    {
        $this->setModeratedStringSiteFieldAutoApprove(
            "subject",
            \NoizuLabs\Core\DomainObject\ModeratedString::EMAIL_TEMPLATE_SUBJECT,
            $value,
            array('action' => $action, 'empty' => true));
    }
}
