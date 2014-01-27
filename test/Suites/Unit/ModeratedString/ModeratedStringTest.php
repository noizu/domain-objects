<?php
namespace NoizuLabs\Core\Tests\Suites\Unit\ModeratedString;
require_once( __DIR__ . '/../UnitTestBase.php');

/**
 * @stepClass \NoizuLabs\Core\Tests\Steps\Given
 * @stepClass \NoizuLabs\Core\Tests\Steps\Then
 */
class ModeratedStringTest extends \NoizuLabs\Core\Tests\Suites\Unit\UnitTestBase
{
    /**
     * @When the user creates a moderated string
     */
    public function WhenTheUserCreatesAModeratedString()
    {
        $ms = new \NoizuLabs\Core\DomainObject\Repository\ModeratedStrings();
        $userId = $this->user->getId();
        $stringType = 1;
        $this->moderatedString = $ms->CreateModeratedString("Hello World", $stringType, $this->user->getFixture());
    }

    /**
     * @When the admin user approves it
     */
    public function WhenTheAdminUserApprovesIt()
    {

    }
}
