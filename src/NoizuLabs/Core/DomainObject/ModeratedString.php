<?php
namespace NoizuLabs\Core\DomainObject;

/* @ToDo,  auto find and load type identifers to avoid need to update constants here and in db*/

class ModeratedString extends \NoizuLabs\Core\DomainObject
{
	function __construct()
	{
	    parent::__construct();
	}

	function __destruct()
	{
	}

    public function load($mixed)
    {
        $this->entity = null;
        $this->loaded = false;

        if(is_object($mixed))
        {
            $this->entity = $mixed;
            $this->loaded = true;
        } else  if(is_int($mixed))
        {
            $msc = $this->container['EntityClass_ModeratedStrings'];
            $entityManager = $this->container['EntityManager'];
            $query = $entityManager->createQuery("SELECT u FROM $msc ms where ms.id = :id");
            $query->setParameters(array(
                'id' => $mixed,
            ));

            $entities = $query->getResult();


            if(count($entities) > 0)
            {
                $this->entity = $entities[0];
                $this->loaded = true;
            } else {

            }
        }
        return $this->loaded;
    }

    public function edit($value, $options = array()) {
        $author = isset($options['author']) ? $options['author'] : null;
        $action = isset($options['action']) ? $options['action'] : null;
        $autoApprove = isset($options['autoApprove']) ? $options['autoApprove'] : null;

        if($autoApprove) {
            $string = $this->getApprovedText()->getString();
        } else {
            $string = $this->getPendingText()->getString();
        }

        if($string !== $value) {
            $string = $this->createChangeLog($value, $author, $action);
            if($string) {
                if($autoApprove) {
                    $this->setApprovedText($string);
                } else {
                    $this->setPendingText($string);
                }
                $this->save();
            }
        }
    }

    public function createChangeLog($string, $author, $action) {
        $em = $this->container['EntityManager'];
        $entityLogs = $this->container['Entity_ModeratedStringChangeLogs'];
        $poAction = $em->getPartialReference(
            $this->container['EntityClass_ModeratedStringActions'],
            isset($action) ?  $action : $this->GetUserEditId());

        $entityLogs->setAction($poAction);
        $entityLogs->setAutoFlag($this->autoFlag($string, $this->getStrType(), $author));
        $entityLogs->setEventTimeStamp(null);
        $entityLogs->setModeratedString($this->entity);
        $entityLogs->setString($string);
        $entityLogs->setUser($author->getEntity());
        $em->persist($entityLogs);
        $em->flush();
        return $entityLogs;
    }

    public function autoFlag($string, $type, $author)
    {
        return false;
    }

	public function getApprovedText()
	{
	    return $this->entity->getApprovedText();
	}

	public function getPendingText()
	{
	    return $this->entity->getPendingText();
	}

	public function setPendingText($value)
	{
	    $this->entity->setPendingText($value);
	}

	public function setApprovedText($value)
	{
	    $this->entity->setApprovedText($value);
	}

	public function hasPendingString()
	{
	    if($this->entity->getApprovedText() == null) return true;
	    return $this->entity->getPendingText()->getId() !== $this->entity->getApprovedText()->getId();
	}

	public function getRevisionHistory()
	{
	}

	public function getStrType()
	{
        return $this->entity->getStrType();
	}

	public function getId()
	{
	   return $this->entity->getId();
	}

	public function __string()
	{
	}
}
?>
