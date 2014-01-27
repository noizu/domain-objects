<?php
namespace NoizuLabs\Core\DomainObject\Repository;
use NoizuLabs\Core\DomainObject as DomainObject;

class EmailTemplates extends \NoizuLabs\Core\DomainObject\Repository
{
	function __construct()
	{
	    parent::__construct();
	}

	function __destruct()
	{

	}

	public function getTemplate($id, $raw = false)
	{
	    $entityManager = $this->container['EntityManager'];
            $etc = $this->container['EntityClass_EmailTemplates'];
	    $query = $entityManager->createQuery("
	           SELECT t
	            FROM
	                $etc as t
	            WHERE
	               t.id = :id
	        ");

	    if(is_object($id)) {
	        $id = $id->getId();
	    }
	    $query->setParameters(array(
	        ':id' => $id,
	    ));

	    $entities = $query->getResult();


   	    if(count($entities)) {
   	        if($raw) {
   	            return $entities[0];
   	        } else {
    	        $do = $this->container['Do_EmailTemplate'];
    	        $do->load($entities[0]);
    	        return $do;
   	        }
   	    }
	}

	public function getTemplates()
	{
	    $entityManager = $this->container['EntityManager'];
            $etc = $this->container['EntityClass_EmailTemplates'];
	    $query = $entityManager->createQuery("
	           SELECT t
	            FROM
	                $etc as t
	        ");
	    return $query->getResult();
	}

    public function createTemplate($friendlyName, $subject, $template)
    {
        $do = new $this->container["Do_EmailTemplate"];
        $do->setDefaultFields();
        $do->setFriendlyName($friendlyName);
        $do->setDefaultSubject($template);
        $do->setDefaultTemplate($template);
        $do->save();
        return $do;
    }

}
