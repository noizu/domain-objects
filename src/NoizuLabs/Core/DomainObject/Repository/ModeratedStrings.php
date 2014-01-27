<?php
namespace NoizuLabs\Core\DomainObject\Repository;

class ModeratedStrings extends \NoizuLabs\Core\DomainObject\Repository
{
	function __construct()
	{
	    parent::__construct();
	}


	function __destruct()
	{
	}

	public function createModeratedString($string, $typeId, $author, $autoApprove = false)
	{

            if(is_a($author, $this->container['DoClass_User'])) $author = $author->getEntity(); 
	    if(!is_a($author, $this->container['EntityClass_Users']) &&  $author != null){
            throw new \Exception("createModeratedString expects \$author to be set to null or a User DomainObject. " . get_class($author));
	    }

        // Create Moderated String Entry
	    $em = $this->container['EntityManager'];
	    $entity = $this->container['Entity_ModeratedStrings'];

	    $entity->setApprovedText(null);
	    $entity->setPendingText(null);

	    $poType = $em->getPartialReference($this->container['EntityClass_ModeratedStringTypes'], $typeId);
	    $entity->setStrType($poType);

        $em->persist($entity);
        $em->flush();

        $msid = $entity->getId();

        $entityLogs = $this->container['Entity_ModeratedStringChangeLogs'];
        $poAction = $em->getPartialReference( $this->container['EntityClass_ModeratedStringActions'] , $this->container['Entity_ModeratedStringAction_CreateUser'] );
        $entityLogs->setAction($poAction);
        $entityLogs->setAutoFlag($this->autoFlag($string, $typeId, $author));
        $entityLogs->setEventTimeStamp(null);
        $entityLogs->setModeratedString($entity);
        $entityLogs->setString($string);
        $entityLogs->setUser($author);
        $em->persist($entityLogs);
        $em->flush();

        if($autoApprove) {
            $entity->setApprovedText($entityLogs);
        } else {
            $entity->setPendingText($entityLogs);
        }


        $em->flush();

        $moderatedString = $this->container['Do_ModeratedString'];
        $moderatedString->load($entity);
        return $moderatedString;
	}

	public function autoFlag($string, $typeId, $authorId)
	{
        return false;
	}
}
