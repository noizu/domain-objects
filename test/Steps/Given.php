<?php
namespace NoizuLabs\Core\Tests\Steps;

use NoizuLabs\PHPConform\PHPUnitExtension as PhpConform;

class Given extends PhpConform\StepAbstract
{

    
    /**
    * @Given a user
    */
    public function GivenAUser()
    {
         $this->user = new \NoizuLabs\Core\Tests\Fixtures\User();
    }

    /**
     * @Given a user and an admin user
     */
    public function GivenAUserAndAnAdminUser()
    {
        $this->GivenAUser();
        $this->adminUser = new \NoizuLabs\Core\Tests\Fixtures\User(); // \AdminUser()
    }
        
    /**
     * @Given a registered user
     */
    public function GivenARegisteredUser()
    {
    }
    
    /**
     * @Given a valid user
     */
    public function GivenAValidUser()
    {
    }
        
    /**
     * @Given a verified user
     */
    public function GivenAVerifiedUser()
    {
    }
        
    /**
     * @Given a non-verified user
     */
    public function GivenANonVerifiedUser()
    {
    }
    
    /**
     * @Given a logged in user
     */
    public function GivenALoggedInUser()
    {
    }

    /**
     * @Given a non-logged in user
     */ 
    public function GivenANonLoggedInUser()
    {
    }
        
    /**
     * @Given a banned user
     */
    public function GivenABannedUser()
    {
    }
    
    /**
     * @Given a banned logged in user
     */
    public function GivenABannedLoggedInUser()
    {
    }
    
    /**
     * @Given a deactivated user
     */
    public function GivenADeactivatedUser()
    {
    }
    
    /**
     * @Given a deactivated logged in user
     */
    public function GivenADeactivatedLoggedInUser()
    {
    }
    
    /**
     * @Given a registered user who is under 13 years of age
     */
    public function GivenAConfirmedUserWhoIsUnder13YearsOfAge()
    {
    }
    
    /**
     * @Given a registered user who is under 13 years of age
     */
    public function GivenAnUnconfirmedUserWhoIsUnder13YearsOfAge()
    {
    }
    
    /**
     * @Given a user with banned ip
     */
    public function GivenAUserWithBannedIp()
    {
    }
    
    /**
     * @Given a parent of a registered user who is under 13 years of age
     */
    public function GivenAParentOfARegisteredUserWhoIsUnder13YearsOfAge()
    {
    }
    
    
}
