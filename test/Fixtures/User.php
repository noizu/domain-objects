<?php

namespace NoizuLabs\Core\Tests\Fixtures;

class User extends \NoizuLabs\Core\Tests\Fixture
{
    var $fixture;

    public function __construct($deleteOnClose = true)
    {
        global $container; 
        $loginname = $this->generateGuid("user", 32);
        $password = $this->generateGuid("pwd", 32);
        $email = $this->generateGuid("test+", 32) . "@noizu.com";
        $userData = compact('loginname','password', 'email');
        $users = $container['Do_Repository_Users']; 
        $outcome = $users->createUser($userData);
        if($outcome) {
            $this->fixture = $outcome;
            $this->register($this->fixture, true);
        } else {
        }
    }

    public function getId() {
       return $this->fixture->getId(); 
    }

    public function getFixture()
    {
        return $this->fixture;
    }
}
