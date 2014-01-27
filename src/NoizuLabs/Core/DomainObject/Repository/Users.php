<?php
namespace NoizuLabs\Core\DomainObject\Repository;

class Users extends \NoizuLabs\Core\DomainObject\Repository
{
     public function createUser($userData)
     {
        $user = $this->container['Do_User'];
        $outcome = $user->save();
        if($outcome) {
            return $user;
        } else {
            return $outcome;
        }
     }
}
