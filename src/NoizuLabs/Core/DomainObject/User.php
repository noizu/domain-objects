<?php
namespace NoizuLabs\Core\DomainObject;

class User extends \NoizuLabs\Core\DomainObject
{
    public $entityName = "\\NoizuLabs\\Core\\Doctrine\\Entity\\Users";
    public $entityDIName = "Entity_Users";

    public function getId() {
        $this->init(); 
        return $this->entity->getId(); 
    }

}
